import { CompanyType } from './CompanyTypes';

type UserType = {
    id?: string;
    name: string;
    email: string;
    login?: string;
    profile?: string;
    position_company: string;
    released_companies: string[];
    password?: string;
    status: boolean;
    created_at?: string;
};

type AuthUserType = {
    id?: string;
    name: string;
    email: string;
    login: string | undefined;
    profile?: string;
    position_company: string;
    released_companies: CompanyType[];
    password?: string;
    status: boolean;
};

export type { UserType, AuthUserType };