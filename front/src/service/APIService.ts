import axios, { AxiosInstance, AxiosRequestConfig, AxiosResponse, AxiosError } from 'axios';
import router from '@/router/index';

interface CustomHeaders {
    Accept: string;
    'Content-Type': string;
    Authorization?: string;
    [key: string]: string | undefined;
}

function getCustomHeaders(): CustomHeaders {
  const headers: CustomHeaders = {
    Accept: 'application/json',
    'Content-Type': 'application/json',

  };

  const token = sessionStorage.getItem('access-token');
  if (token && token !== 'undefined') {
    headers.Authorization = `Bearer ${token}`;
  }

  return headers;
}

export default class APIService {
  private static instance: AxiosInstance;

  /* Construtor privado para evitar instanciação */
  private constructor() { return true; }

  private static getInstance(): AxiosInstance {
    if (!APIService.instance) {
      APIService.instance = axios.create({
        baseURL: `http://localhost:8080`,
        // headers: getCustomHeaders(),
        timeout: 60 * 4 * 1000
      });

      APIService.instance.interceptors.request.use(
        (config: AxiosRequestConfig): any => {
          // const urlDestino = config.url || '';
          const customHeaders = getCustomHeaders();

          // if (rotasUpload.includes(urlDestino)) {
          //   config.headers = { ...customHeaders, ...config.headers };
          // } else {
          // }
          config.headers = { ...customHeaders };

          return config;
        },
        (error: AxiosError) => {
          return Promise.reject(error);
        }
      );

      APIService.instance.interceptors.response.use(
        APIService.handleResponse,
        APIService.handleErrorResponse
      );
    }
    return APIService.instance;
  }

  private static handleResponse(response: AxiosResponse) {
    if (response.status === 200 || response.status === 201) {
      return Promise.resolve(response);
    } else {
      return Promise.reject(response);
    }
  }

  private static handleErrorResponse(error: AxiosError) {
    if (error.response && error.response.status) {
      switch (error.response.status) {
      case 401:
      case 403:
        router.push({ name: 'Login' });
        break;
      }
      return Promise.reject(error.response);
    } else {
      return Promise.reject(error);
    }
  }

  public static getApiCall(): AxiosInstance {
    return APIService.getInstance();
  }
}
