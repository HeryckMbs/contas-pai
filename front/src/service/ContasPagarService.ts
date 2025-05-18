import BaseService from "./BaseService";

export default {
  async create(userData: any): Promise<Object> {
    return await BaseService.post(userData, `api/contas-pagar`);
  },

  async update(userData: any): Promise<Object> {
    return await BaseService.put(userData, `api/contas-pagar/${userData.id}`);
  },

  async getAll(mes = '', ano = '',itemsPerPage = 10,page=1): Promise<Object> {
    return await BaseService.get(`api/contas-pagar?mes=${mes}&ano=${ano}&itemsPerPage=${itemsPerPage}&page=${page}`);
  },

  async delete(id: number): Promise<Object> {
    return await BaseService.delete(`api/contas-pagar/${id}`);
  },

  async findById(id: number): Promise<Object> {
    return await BaseService.get(`api/contas-pagar/${id}`);
  },

  async pay(userData: any): Promise<Object> {
    return await BaseService.patch(userData,`api/contas-pagar/${userData.id}/pay`)
  },
};
