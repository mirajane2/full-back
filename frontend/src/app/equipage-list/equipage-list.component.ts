import { Component, OnInit } from '@angular/core';
import { PirateService } from '../services/pirate.service';
import { CommonModule, UpperCasePipe } from '@angular/common';
import { Router } from '@angular/router';

@Component({
  selector: 'app-equipage-list',
  imports: [
    CommonModule,
    UpperCasePipe
  ],
  templateUrl: './equipage-list.component.html',
  styleUrl: './equipage-list.component.scss'
})
export class EquipageListComponent implements OnInit {
  equipages: any[] =[];

  constructor(private pirateService : PirateService, private router: Router) {}

  ngOnInit(): void {
     this.pirateService.getEquipages().subscribe((data: any) => {
      this.equipages = data;
     });
  }

  detailEquipage(crewId : string) {
    this.router.navigate(['/equipage/pirates', crewId ])
  }

  DeleteEquipage(id : number) {
    this.pirateService.deleteEquipage(id).subscribe(() => {
      this.equipages = this.equipages.filter(equipage => equipage.id !== id)
    })
  }

  newEquipage(){
    this.router.navigate(['/equipage/create'])
  }
}
