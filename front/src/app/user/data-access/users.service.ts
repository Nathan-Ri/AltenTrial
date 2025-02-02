import {Injectable, inject, signal} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {catchError, Observable, of, tap} from "rxjs";
import {User} from "./user.model";

@Injectable({
  providedIn: "root"
})
export class UsersService {

  private readonly http = inject(HttpClient);
  private readonly path = "http://127.0.0.1:8000/api/users/";

  private readonly _users = signal<User[]>([]);
  public readonly users = this._users.asReadonly();

  public get(): Observable<User[]> {
    return this.http.get<User[]>(this.path).pipe(
      catchError(() => {
        return []
      }),
      tap((products) => this._users.set(products)),
    );
  }

  public create(user: User): Observable<boolean> {
    return this.http.post<boolean>('http://127.0.0.1:8000/account', user).pipe(
      catchError(() => {
        return of(true);
      }),
      tap(() => this._users.update(users => [user, ...users])),
    );
  }

}
