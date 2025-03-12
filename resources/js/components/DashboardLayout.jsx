import React, { useContext } from "react";
import { AuthContext } from "../contexts/AuthContext";
import Topbar from "./Topbar";

export default function DashboardLayout({ children }) {
    const { currProfile, userType } = useContext(AuthContext);
    return (
        <div className="relative h-screen w-full bg-gradient-to-tr from-lime-700 to-yellow-800 flex items-center justify-center">
            {/* Desktop Icons */}
            <div className="absolute top-10 left-10">
                <button
                    className="flex flex-col items-center text-white"
                    onClick={() => toggleWindow("window1")}
                >
                    <div className="w-16 h-16 bg-lime-600 text-3xl rounded-lg flex items-center justify-center shadow-md">
                        📁
                    </div>
                    <span className="text-sm mt-1">Open Window</span>
                </button>
            </div>

            <div className="absolute top-40 left-10">
                <button
                    className="flex flex-col items-center text-white"
                    onClick={() => toggleWindow("window2")}
                >
                    <div className="w-16 h-16 bg-blue-500 rounded-lg flex items-center justify-center shadow-md">
                        📁
                    </div>
                    <span className="text-sm mt-1">Open Another Window</span>
                </button>
            </div>

            {/* Window Modals */}
            {Object.entries(windows).map(([key, win]) => (
                <Draggable key={key} handle=".handle">
                    <div className="absolute top-20 left-40 w-10/12 h-5/6 bg-gray-800 rounded-lg shadow-xl">
                        <div className="handle flex items-center justify-between bg-gray-700 p-2 cursor-move rounded-t-lg">
                            <div className="flex items-center gap-2">
                                <Move size={16} className="text-gray-400" />
                                <span className="text-white">My Window</span>
                            </div>
                            <div className="flex space-x-2">
                                <button className="text-gray-300 hover:text-white">
                                    <Minus size={16} />
                                </button>
                                <button className="text-gray-300 hover:text-white">
                                    <Maximize size={16} />
                                </button>
                                <button
                                    className="text-red-500 hover:text-red-700"
                                    onClick={() => toggleWindow(key)}
                                >
                                    <X size={16} />
                                </button>
                            </div>
                        </div>
                        <div className="p-4 text-white">
                            This is a draggable window.
                        </div>
                    </div>
                </Draggable>
            ))}
        </div>
    );
}
