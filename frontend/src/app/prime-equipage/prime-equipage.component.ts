import { Component,  OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { PirateService } from '../services/pirate.service';
import { CommonModule, CurrencyPipe } from '@angular/common';


@Component({
  selector: 'app-prime-equipage',
  imports: [
    CurrencyPipe,
    CommonModule
  ],
  templateUrl: './prime-equipage.component.html',
  styleUrl: './prime-equipage.component.scss'
})
export class PrimeEquipageComponent implements OnInit {
  pirates: any[] = [];
  crewId! : number;
  

  constructor(private router: Router,
              private route : ActivatedRoute,
              private pirateService: PirateService
  ){

  }

  ngOnInit(): void {
    this.crewId = +this.route.snapshot.paramMap.get('id')!;
    this.pirateService.getPirates(this.crewId).subscribe((data)=> {
      this.pirates = data;
      console.log("pirates", data);
    });
  }

  DeletePirate(id : number): void {
    this.pirateService.deletePirate(id).subscribe(()=> {
      this.pirates = this.pirates.filter(pirate => pirate.id !== id);
    });
  }

  UpdatePirate(crewId : number, pirateId : string) {
    console.log('crewId:', crewId, 'pirateId:', pirateId);
    this.router.navigate(['/equipage', crewId, 'pirates', pirateId])
  }

  newPirate(){
    this.router.navigate(['/equipage/pirates', this.crewId, 'create']);
  }

}
