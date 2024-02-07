import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import { environment } from '../environments/environment';

@Injectable({ providedIn: 'root'})
export class RestAPIService {
  private baseUrl: string = `${environment.apiURL}`

  constructor(
    public http: HttpClient,
  ) {}

  async get(pathUrl: string, formData: any) {
    const url = `${this.baseUrl}/${pathUrl}`
    return this.http.get(url, formData)
  }

  async post(pathUrl: string, formData: any) {
    const url = `${this.baseUrl}/${pathUrl}`
    return this.http.post(url, formData)
  }
}
