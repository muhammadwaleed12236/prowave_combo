import axios from "axios";

export const getBaseApiUrl = () => {
  if (typeof window !== "undefined") {
    // In browser:
    // If running on local dev (localhost or 127.0.0.1), use localhost backend
    if (window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1") {
      return process.env.NEXT_PUBLIC_API_URL || "http://127.0.0.1:8000/api";
    }
    // On live/production domain (e.g. trendhubstore.binsultansweet.com):
    return `${window.location.origin}/api`;
  }
  return process.env.NEXT_PUBLIC_API_URL || "http://127.0.0.1:8000/api";
};

const api = axios.create({
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
  withCredentials: true,
});

api.interceptors.request.use((config) => {
  config.baseURL = getBaseApiUrl();

  if (typeof window !== "undefined") {
    const token = localStorage.getItem("auth_token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
  }
  return config;
});

export default api;
