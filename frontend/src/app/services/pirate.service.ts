import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";

@Injectable({
    providedIn:'root'
})

export class PirateService {

    constructor(private http: HttpClient) {}

    getEquipages() : Observable<any> {
        return this.http.get(`http://localhost:8000/api/equipage`);
    }

    getPirates(crewId : number) : Observable<any>  {
        return this.http.get(`http://localhost:8000/api/equipage/${crewId}`);
    }

    getPirate(crewId : number, pirateId : number) : Observable<any>  {
        return this.http.get(`http://localhost:8000/api/equipage/${crewId}/pirate/${pirateId}`);
    }

    createPirate(pirate : any) {
        return this.http.post(`http://localhost:8000/api/pirate`, pirate);
    }

    createEquipage(equipage : any) {
        return this.http.post(`http://localhost:8000/api/equipage/create`, equipage);
    }

    updatePirate(crewId : number, pirate : any, pirateId : number) {
        return this.http.put(`http://localhost:8000/api/equipage/${crewId}/pirate/${pirateId}`, pirate);
    }

    deletePirate(id : number){
        return this.http.delete(`http://localhost:8000/api/pirate/${id}`);
    }
    deleteEquipage(id: number) {
        return this.http.delete(`http://localhost:8000/api/equipage/${id}`)
    }
}