import BaseService from "./BaseService";

export default {
  async create(userData: any): Promise<Object> {
    return await BaseService.post(userData, `api/credit-card`);
  },

  async update(userData: any): Promise<Object> {
    return await BaseService.put(userData, `api/credit-card/${userData.id}`);
  },

  async getAll(page=1,itemsPerPage = 10): Promise<Object> {
    return await BaseService.get(`api/credit-card?page=${page}&itemsPerPage=${itemsPerPage}`);
  },

  async delete(id: number): Promise<Object> {
    return await BaseService.delete(`api/credit-card/${id}`);
  },

  async findById(id: number): Promise<Object> {
    return await BaseService.get(`api/credit-card/${id}`);
  },

  async getDetails(id: number): Promise<Object> {
    return await BaseService.get(`api/credit-card/details/${id}`);
  }
};
