import axios from "axios";
import { API_URL } from "../configs/config";

export async function getUnsynced() {
    let res = await axios.post(`${API_URL}get-unsync`, null, {
        headers: {
            Authorization: localStorage.getItem("token"),
        },
    });
    return res.data.data;
}
