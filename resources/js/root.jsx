import { useState, useEffect, useMemo, lazy, Suspense } from "react";
import { AuthContext } from "./contexts/AuthContext";

import { Route, Routes } from "react-router-dom";
import PrivateRoute from "./routes/PrivateRoute";
import PublicRoute from "./routes/PublicRoute";

// //public
const Login = lazy(() => import("./pages/Login"));

//everyone
const Unauthorized = lazy(() => import("./pages/Unauthorized"));

import PreLoader from "./components/PreLoader";
import axios from "axios";
import { API_URL } from "./configs/config";

export default function Root() {
    const [isAuth, setIsAuth] = useState(false);
    const [currProfile, setCurrProfile] = useState({});
    const [isLoading, setIsLoading] = useState(true);
    const [userType, setUserType] = useState("");
    const [currId, setCurrId] = useState(0);
    const [branchDetails, setBranchDetails] = useState({});
    useEffect(() => {
        const handleContextmenu = (e) => {
            e.preventDefault();
        };
        document.addEventListener("contextmenu", handleContextmenu);
        return function cleanup() {
            document.removeEventListener("contextmenu", handleContextmenu);
        };
    }, []);
    function changeAuth(value, id, userType, profile, branchDets) {
        if (value === false) {
            localStorage.removeItem("token");
            setCurrId(0);
            setUserType("");
            setCurrProfile({});
        }
        setUserType(userType);
        setIsAuth(value);
        setCurrId(id);
        setCurrProfile(profile);
        setBranchDetails(branchDets);
    }

    // useEffect(() => {
    //     let abortController;

    //     async function checkToken() {
    //         setIsLoading(true);
    //         abortController = new AbortController();
    //         let signal = abortController.signal;

    //         await axios
    //             .post(
    //                 `${API_URL}check_token`,
    //                 { signal },
    //                 {
    //                     headers: {
    //                         Authorization: localStorage.getItem("token") || "",
    //                     },
    //                 }
    //             )
    //             .then((res) => {
    //                 setUserType(res.data.data.type);
    //                 setCurrId(res.data.data.id);
    //                 setIsAuth(true);
    //                 setCurrProfile(res.data.data.profile);
    //                 setBranchDetails(res.data.data.branch);
    //             })
    //             .catch(() => {
    //                 setUserType("");
    //                 setIsAuth(false);
    //                 setCurrId(0);
    //                 setCurrProfile({});
    //                 localStorage.removeItem("token");
    //             });

    //         setIsLoading(false);
    //     }

    //     checkToken();

    //     return () => abortController.abort();
    // }, []);

    const contextValue = useMemo(
        () => ({
            isAuth,
            isLoading,
            changeAuth,
            currId,
            userType,
            currProfile,
            branchDetails,
        }),
        [isAuth, currId, isLoading, userType, currProfile, branchDetails]
    );

    return (
        <AuthContext.Provider value={contextValue}>
            <Suspense fallback={<PreLoader />}>
                <Routes>
                    {/* <Route exact path="/" element={<PublicRoute />}>
                        <Route path="/" element={<Login />} />
                    </Route> */}
                    <Route path="/" element={<Login />} />
                </Routes>
            </Suspense>
        </AuthContext.Provider>
    );
}
