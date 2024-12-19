import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-one-piece',
  imports: [],
  templateUrl: './one-piece.component.html',
  styleUrl: './one-piece.component.scss'
})
export class OnePieceComponent {

  constructor(private router: Router) {

  }
  OnList() {
    this.router.navigateByUrl('equipage');
  }

}
