import { useState } from "react";
import { Navigate } from "react-router-dom";

export default function LoginScreen({ onLogin }) {
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");

    const handleLogin = () => {
        if (username === "admin" && password === "password") {
            return <Navigate to="/unauthorized" />;
        } else {
            setError("Invalid username or password");
        }
    };

    return (
        <div className="relative h-screen w-full bg-gradient-to-tr from-lime-700 to-yellow-800 flex items-center justify-center">
            <div className="bg-gray-900 p-8 rounded-lg shadow-lg w-96 text-white">
                <h2 className="text-2xl font-bold text-center mb-4">Login</h2>
                {error && (
                    <p className="text-red-500 text-sm text-center">{error}</p>
                )}
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
                    className="mt-6 w-full bg-lime-600 p-2 rounded hover:bg-lime-700"
                    onClick={handleLogin}
                >
                    Login
                </button>
            </div>
        </div>
    );
}
