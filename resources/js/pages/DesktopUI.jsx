import { useState, lazy, useRef } from "react";
import { Move, X } from "lucide-react";
import { ArrowPathIcon } from "@heroicons/react/24/outline";
import Draggable from "react-draggable";

const Sync = lazy(() => import("./Syncing/Sync"));

export default function DesktopUI() {
    const [windows, setWindows] = useState({});
    const draggableRefs = useRef({}); // ✅ Store refs in an object

    const toggleWindow = (key) => {
        setWindows((prevWindows) => {
            const newWindows = { ...prevWindows };
            if (newWindows[key]) {
                delete newWindows[key];
            } else {
                newWindows[key] = getContentForKey(key);
            }
            return newWindows;
        });
    };

    const getContentForKey = (key) => {
        const contentMap = {
            syncWindow: {
                title: "Syncing Window",
                content: <Sync />,
                tailwindCss:
                    "absolute top-20 left-40 bg-gray-800 rounded-lg shadow-xl",
            },
            window2: {
                title: "File Explorer",
                content: "This is another window with different content.",
                tailwindCss:
                    "absolute top-44 left-32 w-10/12 h-5/6 bg-gray-800 rounded-lg shadow-xl",
            },
        };
        return (
            contentMap[key] || {
                title: "Default Window",
                content: "Default window content.",
                tailwindCss:
                    "absolute top-20 left-40 w-10/12 h-5/6 bg-gray-800 rounded-lg shadow-xl",
            }
        );
    };

    return (
        <div className="relative h-screen w-full bg-gradient-to-tr from-lime-700 to-yellow-800 flex items-center justify-center">
            {/* Desktop Icons */}
            <div className="absolute top-10 left-10">
                <button
                    className="flex flex-col items-center text-white"
                    onClick={() => toggleWindow("syncWindow")}
                >
                    <div className="w-16 h-16 bg-blue-200 text-3xl rounded-lg flex items-center justify-center shadow-md">
                        <ArrowPathIcon className="w-10 h-10 text-cyan-600" />
                    </div>
                    <span className="text-sm mt-1">Open Syncing</span>
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
                    <span className="text-sm mt-1">Open Window</span>
                </button>
            </div>

            {/* Window Modals */}
            {Object.entries(windows).map(([key, win]) => {
                return (
                    <Draggable
                        key={key}
                        handle=".handle"
                        nodeRef={draggableRefs.current[key]}
                    >
                        <div
                            ref={draggableRefs.current[key]}
                            className={win.tailwindCss}
                        >
                            <div className="handle flex items-center justify-between bg-gray-700 p-2 cursor-move rounded-t-lg">
                                <div className="flex items-center gap-2">
                                    <Move size={16} className="text-gray-400" />
                                    <span className="text-white">
                                        {win.title}
                                    </span>
                                </div>
                                <div className="flex space-x-2">
                                    <button
                                        className="text-red-500 hover:text-red-700"
                                        onClick={() => toggleWindow(key)}
                                    >
                                        <X size={16} />
                                    </button>
                                </div>
                            </div>
                            <div className="p-4 text-white">{win.content}</div>
                        </div>
                    </Draggable>
                );
            })}
        </div>
    );
}
