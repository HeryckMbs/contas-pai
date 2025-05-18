import BaseService from "./BaseService";

export default {
  async create(userData: any): Promise<Object> {
    return await BaseService.post(userData, `api/category`);
  },

  async update(userData: any): Promise<Object> {
    return await BaseService.put(userData, `api/category/${userData.id}`);
  },

  async getAll(type: string = '',itemsPerPage = 10,page=1): Promise<Object> {
    return await BaseService.get(`api/category?type=${type}&itemsPerPage=${itemsPerPage}&page=${page}`);
  },

  async delete(id: number): Promise<Object> {
    return await BaseService.delete(`api/category/${id}`);
  },

  async findById(id: number): Promise<Object> {
    return await BaseService.get(`api/category/${id}`);
  }
};
