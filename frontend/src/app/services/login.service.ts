import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Router } from "@angular/router";
import { Observable } from "rxjs";

@Injectable({
    providedIn: 'root'
})

export class LoginService {

    constructor(private http : HttpClient,
                private router: Router
    ){}

    login(username: string, password: string): Observable<any> {
        return this.http.post(`http://localhost:8000/api/login`, { username, password });
    }

    setToken(token: string): void {
        localStorage.setItem('token', token);
    }

    getToken(): string | null {
        return localStorage.getItem('token');
    }

    isLoggedIn(): boolean {
        return !!this.getToken();
    }
    logout() {
       localStorage.removeItem('token');
       this.router.navigate(['/login']);
    }
}