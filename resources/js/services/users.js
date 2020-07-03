import axiosRequest from './axios_config'

export default {

    getUsers(page,itemsPerPage) {
        return axiosRequest().get(`/api/auth/users?page=${page}&itemsPerPage=${itemsPerPage}`)
    },

    getUser(id) {
        return axiosRequest().get(`/api/auth/users/${id}`)
    },

    saveUser(data) {
        return axiosRequest().post('/api/auth/users', data)
    },

    updateUser(data, id) {
        return axiosRequest().patch(`/api/auth/users/${id}`, data)
    },

    deleteUser(id) {
        return axiosRequest().delete(`/api/auth/users/${id}`)
    },

    restoreUser(id) {
        return axiosRequest().post(`/api/auth/users/restore/${id}`)
    }
}
