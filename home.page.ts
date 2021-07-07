import { HttpClient } from '@angular/common/http';
import { Component, ViewChild } from '@angular/core';
import { Storage } from '@ionic/storage-angular';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {

  @ViewChild('input') meuInput;

  minhaLista=[];
  texto="";
  
  constructor(private http:HttpClient) {
    //private storage:Storage,
    //this.storage.create();
  }

  ngOnInit(){
    this.atualizaLista();
  }

  async adicionar(){
/*     //procura o maior valor de key
    var a=0;

    this.minhaLista.forEach(item => {
      if(parseInt(item[0]) > a) {
        a=parseInt(item[0]);
      }
    })
    //soma mais 1 no a
    a=a+1; */
    // guarda no storage
    //await this.storage.set(a.toString(),this.texto);
    this.http.post<any[]>("http://localhost/lista/inclui.php",
              { "descricao" : this.texto })
    .subscribe( valor => {
        this.atualizaLista();
    })
    
    this.texto="";
    this.meuInput.setFocus();
  }

  atualizaLista(){
    this.minhaLista=[];
    this.http.get<any>("http://localhost/lista/consulta.php")
             .subscribe( valor => {
               valor.forEach( dados =>{
                 this.minhaLista.push([dados.codigo, dados.descricao]);
               })
             })

    //this.storage.forEach( (value, key, index) => {
    //  this.minhaLista.push([key, value]);
    //});
  }

  async remover(indice){
    //await this.storage.remove(indice);
    this.http.delete<any[]>("http://localhost/lista/remove.php?codigo="+indice)
             .subscribe( valor => {
               this.atualizaLista();
             })
    this.atualizaLista();
    this.meuInput.setFocus();
  }
}
