import APIService from "./APIService";

export default {
    

    
    async post(data: any, path:string): Promise<Object> {
        try {
            const instanceAPI = APIService.getApiCall();
            const response = await instanceAPI.post(path, data)
            return response.data;

        } catch (error) {
            console.log(error);

            return true;
        }
    },

    async put(data: any, path:string): Promise<Object> {
        try {
            const instanceAPI = APIService.getApiCall();
            const response = await instanceAPI.put(path, data)
            return response.data;

        } catch (error) {
            console.log(error);

            return true;
        }
    },
    async patch(data: any, path:string): Promise<Object> {
        try {
            const instanceAPI = APIService.getApiCall();
            const response = await instanceAPI.patch(path, data)
            return response.data;

        } catch (error) {
            console.log(error);

            return true;
        }
    },
    async get( path:string) {
        try {
            const instanceAPI = APIService.getApiCall();

            const response = await instanceAPI.get(path)
            return response.data;

        } catch (error) {
            console.log(error);

            return true;
        }
    },


    async delete(path:string) {
        try {
            const instanceAPI = APIService.getApiCall();

            const response = await instanceAPI.delete(path)
            return response.data;

        } catch (error) {
            console.log(error);

            return true;
        }
    },



}