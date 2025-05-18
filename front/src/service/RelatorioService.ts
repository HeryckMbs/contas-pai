import BaseService from "./BaseService";

export default {
  async create(userData: any): Promise<Object> {
    return await BaseService.post(userData, `api/reports`);
  },

  async getAll(mes = '', ano = '',itemsPerPage = 10,page=1): Promise<Object> {
    return await BaseService.get(`api/reports?mes=${mes}&ano=${ano}&itemsPerPage=${itemsPerPage}&page=${page}`);
  },

  async update(userData: any): Promise<Object> {
    return await BaseService.put(userData,`api/reports/${userData.id}`)
  },

  async delete(id: number): Promise<Object> {
    return await BaseService.delete(`api/reports/${id}`);
  },

  async findById(id: number): Promise<Object> {
    return await BaseService.get(`api/reports/${id}`);
  }
};
