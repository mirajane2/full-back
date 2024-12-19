import { Component, OnInit } from '@angular/core';
import { PirateService } from '../services/pirate.service';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import {  EquipageListComponent } from '../equipage-list/equipage-list.component';
import { CommonModule } from '@angular/common';
import { Equipage } from '../interfaces/Equipage';


@Component({
  selector: 'app-create-pirate',
  imports: [
    FormsModule,
    CommonModule
  ],
  providers: [
    EquipageListComponent
  ],
  standalone: true,
  templateUrl: './create-pirate.component.html',
  styleUrl: './create-pirate.component.scss'
})
export class CreatePirateComponent implements OnInit {

  pirate = {
    name : " ",
    description : "",
    img : "",
    prime : "",
    equipageId : ""
  }

  equipages : Equipage[] = [];

  constructor(private pirateService: PirateService,
              private router: Router,
  ){}

  ngOnInit(): void {
    this.pirateService.getEquipages().subscribe((data: any) => {
     this.equipages = data;
    });
  }

  onSubmit() {
    this.pirateService.createPirate(this.pirate).subscribe({
        next: (data) => {
            console.log('Pirate created:', data);
            this.router.navigate(['/equipage/pirates', this.pirate.equipageId]);
            console.log('Données soumises :', this.pirate);
        },
        error: (error) => {
            console.error('Error creating pirate:', error);
        },
        complete: () => {
            console.log('Pirate creation process complete.');
        }
      })
    }
}
