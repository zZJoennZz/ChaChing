<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\LoanApplicationHistory;
use App\Models\Member;
use App\Models\MemberHistory;
use App\Models\MemberProfile;
use App\Models\MemberSubInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    //

    public function get_unsync()
    {
        $url = env("SYNC_API_URL");
        $payload = [
            "SECRET" => env("API_SECRET"),
            "API_KEY" => env("API_KEY")
        ];

        try {
            DB::beginTransaction();
            // Fetch data from API
            $response = Http::post($url, $payload);

            // Check if request is successful
            if ($response->failed()) {
                DB::rollBack();
                Log::error("Failed to fetch members: " . $response->body());
                return send400Response('Failed to fetch members.');
            }

            $members = $response->json();

            $returnMemberData = [];

            foreach ($members as $memberData) {
                // Store or update the member
                $member = Member::where('online_ref_id', $memberData['id'])->get();

                if ($member->count() > 0) {
                    continue;
                }

                $new_member = new Member();
                $new_member->member_id = $memberData['member_id'];
                $new_member->status = $memberData['status'];
                $new_member->email_address = $memberData['email_address'];
                $new_member->member_since_date = $memberData['member_since_date'];
                $new_member->online_ref_id = $memberData['id'];
                $new_member->save();

                // Store or update the profile
                if (isset($memberData['profile'])) {
                    $memberProfile = new MemberProfile();
                    $memberProfile->members_id = $new_member->id;
                    $memberProfile->address_1 = $memberData['profile']['address_1'];
                    $memberProfile->barangays_id = $memberData['profile']['barangays_id'];
                    $memberProfile->birthday = $memberData['profile']['birthday'];
                    $memberProfile->cities_id = $memberData['profile']['cities_id'];
                    $memberProfile->civil_status = $memberData['profile']['civil_status'];
                    $memberProfile->college_or_department = $memberData['profile']['college_or_department'];
                    $memberProfile->contributions_percentage = $memberData['profile']['contributions_percentage'];
                    $memberProfile->countries_id = $memberData['profile']['countries_id'];
                    $memberProfile->employee_number = $memberData['profile']['employee_number'];
                    $memberProfile->employee_status = $memberData['profile']['employee_status'];
                    $memberProfile->employment_date = $memberData['profile']['employment_date'];
                    $memberProfile->first_name = $memberData['profile']['first_name'];
                    $memberProfile->gender = $memberData['profile']['gender'];
                    $memberProfile->house_status = $memberData['profile']['house_status'];
                    $memberProfile->last_name = $memberData['profile']['last_name'];
                    $memberProfile->middle_name = $memberData['profile']['middle_name'];
                    $memberProfile->name_on_check = $memberData['profile']['name_on_check'];
                    $memberProfile->phone_number_1 = $memberData['profile']['phone_number_1'];
                    $memberProfile->phone_number_2 = $memberData['profile']['phone_number_2'];
                    $memberProfile->photo = $memberData['profile']['photo'];
                    $memberProfile->provinces_id = $memberData['profile']['provinces_id'];
                    $memberProfile->regions_id = $memberData['profile']['regions_id'];
                    $memberProfile->signature = $memberData['profile']['signature'];
                    $memberProfile->tin_number = $memberData['profile']['tin_number'];
                    $memberProfile->save();
                }

                // Store or update sub information
                if (!empty($memberData['sub_information'])) {
                    foreach ($memberData['sub_information'] as $subInfo) {
                        $new_sub_information = new MemberSubInformation();
                        $new_sub_information->members_id = $new_member->id;
                        $new_sub_information->information_type = $subInfo['information_type'];
                        $new_sub_information->sub_information = $subInfo['sub_information'];
                        $new_sub_information->save();
                    }
                }

                // Store or update history
                if (!empty($memberData['histories'])) {
                    foreach ($memberData['histories'] as $historyData) {
                        $new_member_history = new MemberHistory();
                        $new_member_history->members_id = $new_member->id;
                        $new_member_history->title = $historyData['title'];
                        $new_member_history->visibility = $historyData['visibility'];
                        $new_member_history->notes = $historyData['notes'];
                        $new_member_history->others = $historyData['others'];
                        $new_member_history->save();
                    }
                }
                array_push($returnMemberData, $memberData['id']);
            }

            $url = env("SYNC_LOANS_API_URL");
            $payload = [
                "SECRET" => env("API_SECRET"),
                "API_KEY" => env("API_KEY")
            ];

            // Fetch data from API
            $response = Http::post($url, $payload);

            // Check if request is successful
            if ($response->failed()) {
                DB::rollBack();
                Log::error("Failed to fetch loans: " . $response->body());
                return send400Response('Failed to fetch loans.');
            }

            $loans = $response->json();
            $returnLoanData = [];

            foreach ($loans as $loanData) {
                $loan = LoanApplication::where('online_ref_id', $loanData['id'])->get();

                if ($loan->count() > 0) {
                    continue;
                }

                $new_loan_app = new LoanApplication();
                $new_loan_app->loan_id = $loanData['loan_id'];
                $new_loan_app->online_ref_id = $loanData['id'];
                $new_loan_app->status = $loanData['status'];
                $new_loan_app->data = $loanData['data'];
                $new_loan_app->save();

                if (!empty($loanData['histories'])) {
                    foreach ($loanData['histories'] as $historyData) {
                        $new_loan_history = new LoanApplicationHistory();
                        $new_loan_history->loan_applications_id = $new_loan_app->id;
                        $new_loan_history->title = $historyData['title'];
                        $new_loan_history->visibility = $historyData['visibility'];
                        $new_loan_history->notes = $historyData['notes'];
                        $new_loan_history->others = $historyData['others'];
                        $new_loan_history->save();
                    }
                }

                array_push($returnLoanData, $loanData['id']);
            }

            $response = Http::post(env("PROCESS_SYNC_API_URL"), [
                "SECRET" => env("API_SECRET"),
                "API_KEY" => env("API_KEY"),
                'profile_ids' => $returnMemberData,
                'loan_ids' => $returnLoanData
            ]);

            if ($response->failed()) {
                DB::rollBack();
                Log::error("Failed to fetch loans: " . $response->body());
                return send400Response('Failed to fetch loans.');
            }

            DB::commit();

            return send200Response();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error syncing members and loans: " . $e->getMessage());
            return send400Response("Something went wrong! Error syncing members and loans.");
        }
    }
}
