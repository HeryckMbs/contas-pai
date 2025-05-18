import BaseService from "./BaseService";

export default {


  async getAll(): Promise<Object> {
    return await BaseService.get(`api/notifications`);
  },
  async readNotifications(notifications:any): Promise<Object> {
    return await BaseService.put({'notifications':notifications},`api/read-notifications`,);
  },
  

};
