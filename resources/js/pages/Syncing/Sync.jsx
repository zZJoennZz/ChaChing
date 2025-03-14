import React from "react";
import {
    ExclamationTriangleIcon,
    ArrowPathIcon,
} from "@heroicons/react/24/outline";

import { getUnsynced } from "../../utils/syncFn";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { toast } from "react-toastify";

export default function Sync() {
    const queryClient = useQueryClient();

    const startGetUnsynced = useMutation({
        mutationFn: () => getUnsynced(),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["allMembers"] });
            toast.success("Sync success!");
        },
        onError: (err) => {
            toast.error(err.response.data.message);
        },
        networkMode: "always",
    });

    function startSyncing() {
        if (confirm("Confirm syncing process.")) {
            startGetUnsynced.mutate();
        }
    }
    return (
        <div>
            <div className="rounded-md bg-yellow-600 text-black text-center p-3 text-sm shadow-lg">
                <ExclamationTriangleIcon className="float-start h-8 w-8 mr-2" />
                Once the syncing starts, please <strong>DO NOT</strong> reload,
                or move away from this page. Wait for the sync to complete.
            </div>
            <div className="mt-11 flex items-center justify-center">
                <button
                    disabled={startGetUnsynced.isLoading}
                    onClick={startSyncing}
                    className={`bg-gradient-to-t ${
                        startGetUnsynced.isLoading
                            ? "from-slate-500 to-slate-300"
                            : "from-blue-500 to-cyan-300"
                    } p-5 rounded-full border-4 border-slate-700 shadow-lg transition-all ease-in-out duration-300 ${
                        startGetUnsynced.isLoading && "animate-spin"
                    } hover:animate-pulse`}
                >
                    <ArrowPathIcon className="block w-40 h-40" />
                </button>
            </div>
            <div className="mt-5 text-xs italic text-center">
                Click the button above to start syncing.
            </div>
        </div>
    );
}
