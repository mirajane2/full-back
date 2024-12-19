import { Component, OnInit } from '@angular/core';
import { PirateService } from '../services/pirate.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-update-pirate',
  imports: [
    CommonModule,
    FormsModule
  ],
  providers: [],
  standalone: true,
  templateUrl: './update-pirate.component.html',
  styleUrls: ['./update-pirate.component.scss']
})
export class UpdatePirateComponent implements OnInit {
  crewId!: number
  pirateId! : number;
  pirate = {
    name : " ",
    description : "",
    img : "",
    prime : "",
  }
  constructor(
    private pirateService: PirateService,
    private route: ActivatedRoute,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.crewId = +this.route.snapshot.paramMap.get('crewId')!;
    this.pirateId = +this.route.snapshot.paramMap.get('pirateId')!;
  
    this.pirateService.getPirate(this.crewId, this.pirateId).subscribe({
      next: (data) => {
        this.pirate = data;
      },
      error: (error) => {
        console.error('Erreur lors de la récupération des données du pirate:', error);
        alert('Une erreur est survenue lors du chargement des données.');
      }
    });
  }
  

  onSubmit(): void {

      this.pirateService.updatePirate( this.crewId, this.pirate, this.pirateId).subscribe({
        next: (response) => {
          this.router.navigate(['equipage/pirates', this.crewId]); 
        },
        error: (error) => {
          console.error('Erreur lors de la mise à jour:', error);
          alert('Une erreur est survenue. Veuillez réessayer.');
        },
      });
    }
  }


