import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { LoginService } from '../services/login.service';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-login',
  imports: [
    FormsModule
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})
export class LoginComponent implements OnInit {
  username : string = '';
  password : string = '';
  errorMessage: string = '';

  constructor(private auth : LoginService,
              private router : Router) {

  }

  onLogin(): void{
    this.auth.login(this.username, this.password).subscribe({
      next : (response) => {
        if(response.token) {
          this.auth.setToken(response.token);
          console.log('connexion reussie: ', response);
          this.router.navigateByUrl('/equipage')
        }
        else {
          this.errorMessage = 'erreur'
        }
      },
      error : (err) => {
        this.errorMessage = 'Identifinat invalides ou erreur de serveur';
        console.log(err);
      }
    })
    
  }

  ngOnInit(): void {}

}
