// src/plugins/dateUtils.ts


export default {
    install:(app,options )=> {
        app.config.globalProperties.$getDateInfo = function()  {
            const years = Array.from({ length: 12 }, (v, k) => 2022 + k);
            const mesesDoAno = [
                'Janeiro',
                'Fevereiro',
                'Março',
                'Abril',
                'Maio',
                'Junho',
                'Julho',
                'Agosto',
                'Setembro',
                'Outubro',
                'Novembro',
                'Dezembro'
            ];

            const months = Array.from({ length: 12 }, (v, k) => ({
                text: mesesDoAno[k],
                value: k + 1
            }));

            const dataAtual = new Date();
            const mesAtual = mesesDoAno[dataAtual.getMonth()]; // Nome do mês

            const monthSelected = {
                text: mesAtual,
                value: dataAtual.getMonth() + 1
            };

            return { years, months, monthSelected };
        }
    }
}
