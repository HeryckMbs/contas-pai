
import BaseService from "./BaseService";

export default {
  async create(userData: any): Promise<Object> {
   return await BaseService.post(userData,`api/shopping`)
  },

  async update(userData: any): Promise<Object> {
    return await BaseService.put(userData,`api/shopping/${userData.id}`)
  },
  async pay(userData: any): Promise<Object> {
    return await BaseService.patch(userData,`api/shopping/${userData.id}/pay`)
  },
  async getAll(mes = '', ano = '', itemsPerPage = 10,page = 1) {
    return await BaseService.get(`api/shopping?mes=${mes}&ano=${ano}&itemsPerPage=${itemsPerPage}&page=${page}`);
  },
  async getAllShoppingCategories() {
    return await BaseService.get(`api/shopping-category`);
  },

  async delete(id: number) {
    return await BaseService.get(`api/shopping/${id}`)

  },
  async findById(id: number) {
    return await BaseService.get(`api/shopping/${id}`);
  },

}