import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { PirateService } from '../services/pirate.service';

@Component({
  selector: 'app-create-equipage',
  imports: [
    FormsModule,
    CommonModule
  ],
  standalone : true,
  templateUrl: './create-equipage.component.html',
  styleUrl: './create-equipage.component.scss'
})
export class CreateEquipageComponent {

  equipage = {
    name : ""
  }
 

  constructor(private router : Router,
    private pirateService : PirateService
  ){

  }

  onSubmit() {
    this.pirateService.createEquipage(this.equipage).subscribe({
        next: (data) => {
            console.log('Equipage created:', data);
            this.router.navigate(['/equipage']);
            console.log('Données soumises :', this.equipage);

        },
        error: (error) => {
            console.error('Error creating equipage:', error);
        },
        complete: () => {
            console.log('Equipage creation process complete.');
        }
      })
    }
}
