import { Routes } from '@angular/router';
import { OnePieceComponent } from './one-piece/one-piece.component';
import { LoginComponent } from './login/login.component';
import { AuthGuard } from './auth.guard';
import { EquipageListComponent } from './equipage-list/equipage-list.component';
import { PrimeEquipageComponent } from './prime-equipage/prime-equipage.component';
import { CreatePirateComponent } from './create-pirate/create-pirate.component';
import { CreateEquipageComponent } from './create-equipage/create-equipage.component';
import { UpdatePirateComponent } from './update-pirate/update-pirate.component';

export const routes: Routes = [
    {path : 'login', component: LoginComponent},
    {path : '', component : OnePieceComponent},
    {path: 'equipage', component: EquipageListComponent, canActivate:[AuthGuard]},
    {path : 'equipage/create', component : CreateEquipageComponent, canActivate:[AuthGuard]},
    {path: 'equipage/pirates/:id', component: PrimeEquipageComponent, canActivate:[AuthGuard]},
    {path : 'equipage/pirates/:id/create', component: CreatePirateComponent, canActivate:[AuthGuard]},
    {path : 'equipage/:crewId/pirates/:pirateId', component : UpdatePirateComponent, canActivate:[AuthGuard]}
];
