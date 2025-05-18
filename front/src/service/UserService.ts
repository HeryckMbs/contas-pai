import BaseService from "./BaseService";

export default {
  async createUser(userData: any): Promise<Object> {
    return await BaseService.post(userData, `api/user`);
  },

  async getAll(): Promise<Object> {
    return await BaseService.get(`api/user`);
  },

  async getGroupsPermission(): Promise<Object> {
    return await BaseService.get(`api/group`);
  },

  async getPermission(): Promise<Object> {
    return await BaseService.get(`api/permission`);
  },

  async deleteGroup(id: number): Promise<Object> {
    return await BaseService.delete(`api/group/${id}`);
  },

  async findGroupById(id: number): Promise<Object> {
    return await BaseService.get(`api/group/${id}`);
  },

  async deletePermission(id: number): Promise<Object> {
    return await BaseService.delete(`api/permission/${id}`);
  },

  async createGroup(groupData: any): Promise<Object> {
    return await BaseService.post(groupData, `api/group`);
  },

  async createPermission(permissionData: any): Promise<Object> {
    return await BaseService.post(permissionData, `api/permission`);
  }
};
