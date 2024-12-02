import axios from 'axios';

const apiClient = axios.create({
    baseURL: '/api', // Replace with your API base URL if necessary
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true, // Enable this if your app uses cookies for authentication
});

export { apiClient };
