import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:5000', // SANGAT PENTING: Sesuaikan dengan PORT backend Express Anda
    headers: {
        'Content-Type': 'application/json'
    }
});

export default api;