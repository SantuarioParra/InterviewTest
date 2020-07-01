import axiosRequest from './axios_config';
import axiosMultipartRequest from './axios_multipart_config';

export default {

    getProducts(page, itemsPerPage) {
        return axiosRequest().get(`/api/products?page=${page}&itemsPerPage=${itemsPerPage}`)
    },

    getProduct(id) {
        return axiosRequest().get(`/api/products/${id}`)
    },

    saveProduct(data) {
        return axiosRequest().post('/api/products', data)
    },

    updateProduct(data, id) {
        return axiosRequest().put(`/api/products/${id}`, data)
    },

    deleteProduct(id) {
        return axiosRequest().delete(`/api/products/${id}`)
    },

    restoreProduct(id) {
        return axiosRequest().delete(`/api/products/restore/${id}`)
    }
}
