import BaseService from './BaseService';

class DashboardCartaoCredito {
    static async getSaldo(mes = '', ano = '') {
        return await BaseService.get(`api/dashboard-cartao/get-total?ano=${ano}&mes=${mes}`);
    }

    static async getFavoriteCreditCard(mes = '', ano = '') {
        return await BaseService.get(`api/dashboard-cartao/get-favorite-card?ano=${ano}&mes=${mes}`);
    }

    static async getFavoriteShopping(mes = '', ano = '') {
        return await BaseService.get(`api/dashboard-cartao/get-favorite-shopping?ano=${ano}&mes=${mes}`);
    }

    static async getRareShopping(mes = '', ano = '') {
        return await BaseService.get(`api/dashboard-cartao/get-rare-shopping?ano=${ano}&mes=${mes}`);
    }

    static async getMostShoppingDay(mes = '', ano = '') {
        return await BaseService.get(`api/dashboard-cartao/get-most-shopping-day?ano=${ano}&mes=${mes}`);
    }

    static async getCardsComparison(mes = '', ano = '') {
        return await BaseService.get(`api/dashboard-cartao/get-cards-comparison?ano=${ano}&mes=${mes}`);
    }

    static async getCardsComparisonCategory(mes = '', ano = '') {
        return await BaseService.get(`api/dashboard-cartao/get-cards-comparison-category?ano=${ano}&mes=${mes}`);
    }

    static async getCategorySpent(mes = '', ano = '') {
        return await BaseService.get(`api/dashboard-cartao/get-category-spent?ano=${ano}&mes=${mes}`);
    }
    static async getMonthlySpentCard(mes = '', ano = '') {
        return await BaseService.get(`api/dashboard-cartao/get-monthly-spent-card?ano=${ano}&mes=${mes}`);
    }
    
}

export default DashboardCartaoCredito;
