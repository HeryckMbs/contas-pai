import BaseService from "./BaseService";

export default {
  async getSaldo(mes = '', ano = ''): Promise<Object> {
    return await BaseService.get(`api/dashboard/get-saldo?ano=${ano}&mes=${mes}`);
  },
  async getSaldoPrevisao(mes = '',ano = ''): Promise<Object> {
    return await BaseService.get(`api/dashboard/get-saldo-previsao?mes=${mes}&ano=${ano}`);
  },
  async getSaldoAnual( ano = ''): Promise<Object> {
    return await BaseService.get(`api/dashboard/get-saldo-anual?ano=${ano}`);
  },
  async getTotalPagoMes(filter = '', mes = '', ano = ''): Promise<Object> {
    return await BaseService.get(`api/dashboard/get-pagos?type=${filter}&ano=${ano}&mes=${mes}`);
  },
  async getRecebidoMes(filter = '', mes = '', ano = ''): Promise<Object> {
    return await BaseService.get(`api/dashboard/get-recebidos?type=${filter}&ano=${ano}&mes=${mes}`);
  },
  async getPagarReceber( ano = ''): Promise<Object> {
    return await BaseService.get(`api/dashboard/get-pagar-receber?ano=${ano}`);
  },
  async getTotalDespesasCategory(mes = '', ano = ''): Promise<Object> {
    return await BaseService.get(`api/dashboard/get-total-despesas?ano=${ano}&mes=${mes}`);
  },
  async getReceitasCategoria(mes = '', ano = ''): Promise<Object> {
    return await BaseService.get(`api/dashboard/get-total-receitas?ano=${ano}&mes=${mes}`);
  },
};
