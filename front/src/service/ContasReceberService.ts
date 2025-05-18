import BaseService from "./BaseService";

export default {
  async create(userData: any): Promise<Object> {
    return await BaseService.post(userData, `api/contas-receber`);
  },

  async update(userData: any): Promise<Object> {
    return await BaseService.put(userData, `api/contas-receber/${userData.id}`);
  },

  async getAll(mes = '', ano = '',itemsPerPage ='',page = 1): Promise<Object> {
    return await BaseService.get(`api/contas-receber?mes=${mes}&ano=${ano}&itemsPerPage=${itemsPerPage}&page=${page}`);
  },

  async delete(id: number): Promise<Object> {
    return await BaseService.delete(`api/contas-receber/${id}`);
  },

  async findById(id: number): Promise<Object> {
    return await BaseService.get(`api/contas-receber/${id}`);
  },
  async receive(userData: any): Promise<Object> {
    return await BaseService.patch(userData,`api/contas-receber/${userData.id}/receive`)
  },
};
