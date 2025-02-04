import {inject, Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {catchError, of, tap} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private readonly http = inject(HttpClient)
  private readonly path = "http://127.0.0.1:8000";
  getToken(): string | null {
    try {
      return localStorage.getItem('auth_token');
    } catch (error) {
      console.error('Accès à localStorage interdit:', error);
      return null;
    }
  }


  login(payload: { email: string | undefined; password: string | undefined }) {
    return this.http.post<{email:string, token: string, expires_at: string}>(`${this.path}/authenticate/login`, payload).pipe(
      tap((tokenData) => localStorage.setItem('auth_token', tokenData.token))
    )
  }
}
