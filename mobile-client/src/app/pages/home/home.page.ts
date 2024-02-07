import {Component, OnInit} from '@angular/core';
import {
  IonButton,
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCol,
  IonContent,
  IonGrid,
  IonImg,
  IonItem,
  IonLabel,
  IonList,
  IonListHeader,
  IonNote,
  IonRow,
  IonText
} from '@ionic/angular/standalone';
import {StorageService} from "../../../services/storage.service";
import {ACCESS_TOKEN_KEY} from "../../utils/constants";
import {Router} from "@angular/router";

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
  standalone: true,
  imports: [
    IonContent,
    IonText,
    IonImg,
    IonGrid,
    IonRow,
    IonCol,
    IonCard,
    IonCardHeader,
    IonCardContent,
    IonButton,
    IonList,
    IonItem,
    IonLabel,
    IonNote,
    IonListHeader
  ],
})
export class HomePage implements OnInit {
  constructor(
    private storageService:  StorageService,
    private router: Router,
  ) {}

  async ngOnInit() {
    setTimeout(() => {
      this.storageService.get(ACCESS_TOKEN_KEY).then((token) => {
        if (!token) {
          this.router?.navigateByUrl('/signin', { replaceUrl: true })
          return
        }
      })
    }, 1)
  }
}
