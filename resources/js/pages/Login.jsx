import { useContext, useState } from "react";

import { AuthContext } from "../contexts/AuthContext";
import { API_URL } from "../configs/config";
import { toast } from "react-toastify";

export default function Login() {
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");

    const { changeAuth } = useContext(AuthContext);

    async function performLogin(e) {
        e.preventDefault();
        axios
            .post(`${API_URL}login`, { username, password })
            .then((res) => {
                console.log(res);
                localStorage.setItem("token", "Bearer " + res.data.data.token);

                changeAuth(
                    true,
                    res.data.data.id,
                    res.data.data.type,
                    res.data.data.profile,
                    res.data.data.branch
                );
                toast.success("Login success!");
            })
            .catch((err) => {
                if (err.name && err.name === "AxiosError") {
                    toast.error(err.response.data.message);
                    localStorage.removeItem("token");
                }
            });
    }
    return (
        <div className="relative h-screen w-full bg-gradient-to-tr from-lime-700 to-yellow-800 flex items-center justify-center">
            <div className="bg-gray-900 p-8 rounded-lg shadow-lg w-96 text-white">
                <h2 className="text-2xl font-bold text-center mb-4">Login</h2>
                <form onSubmit={performLogin}>
                    <div className="mt-4">
                        <label className="block text-sm">Username</label>
                        <input
                            type="text"
                            className="w-full p-2 mt-1 bg-gray-800 border border-gray-700 rounded"
                            value={username}
                            onChange={(e) => setUsername(e.target.value)}
                        />
                    </div>
                    <div className="mt-4">
                        <label className="block text-sm">Password</label>
                        <input
                            type="password"
                            className="w-full p-2 mt-1 bg-gray-800 border border-gray-700 rounded"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                        />
                    </div>
                    <button
                        type="submit"
                        className="mt-6 w-full bg-lime-600 p-2 rounded hover:bg-lime-700"
                    >
                        Login
                    </button>
                </form>
            </div>
        </div>
    );
}
