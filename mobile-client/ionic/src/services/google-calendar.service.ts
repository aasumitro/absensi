import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import { environment } from '../environments/environment';
import {map, Observable} from "rxjs";

@Injectable({ providedIn: 'root'})
export class GoogleCalendarService {
  private baseUrl: string = `${environment.googleCalendarApiUrl}/${environment.googleCalendarId}/events`

  constructor(
    public http: HttpClient,
  ) {}

  getHolidayBetweenDates(startDateString: string, endDateString: string): Observable<any> {
    const timeMin = `${startDateString}T00:00:00Z`;
    const timeMax = `${endDateString}T23:59:59Z`;
    const queryString = `key=${environment.googleCalendarApiKey}&timeMin=${timeMin}&timeMax=${timeMax}&maxResults=100`;
    const url = `${this.baseUrl}?${queryString}`;
    return this.http.get<any[]>(url);
  }
}
