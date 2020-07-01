import axiosRequest from './AxiosConfig';
import axiosMultipartRequest from './AxiosMultipartConfig';

export default {

    getProducts(page, itemsPerPage) {
        return axiosRequest().get(`/api/products?page=${page}&itemsPerPage=${itemsPerPage}`)
    },

    getProduct(id) {
        return axiosRequest().get(`/api/products/${id}`)
    },

    saveProduct(data) {
        return axiosMultipartRequest().post('/api/products', data)
    },

    updateProduct(data, id) {
        return axiosMultipartRequest().put(`/api/products/${id}`, data)
    },

    deleteProduct(id) {
        return axiosRequest().delete(`/api/products/${id}`)
    },

    restoreProduct(id) {
        return axiosRequest().delete(`/api/products/restore/${id}`)
    }
}
