import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: { 'Content-Type': 'application/json' }
});

api.interceptors.response.use(
    (res) => res,
    (err) => {
        console.error('[API ERROR]', err?.response?.status, err?.response?.data || err.message);
        return Promise.reject(err);
    }
);

export default api;