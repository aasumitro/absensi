import {Component, OnDestroy, OnInit} from '@angular/core';
import {IonContent, IonImg} from '@ionic/angular/standalone';
import {interval, Subscription} from "rxjs";
import {Router} from "@angular/router";
import {ACCESS_TOKEN_EXPIRED_IN_KEY, ACCESS_TOKEN_KEY} from "../../utils/constants";
import {StorageService} from "../../../services/storage.service";

@Component({
  selector: 'app-preload',
  template: `
    <ion-content [fullscreen]="true">
      <div id="container">
        <ion-img
          src="assets/images/absensi_159x159.png"
          alt="absensi-logo"
        ></ion-img>
      </div>
    </ion-content>
  `,
  styles: [`
    ion-content {
      --overflow: hidden;
      #container {
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        ion-img {
          width: 125px;
          height: 125px;
        }
      }
    }
  `],
  standalone: true,
  imports: [IonContent, IonImg]
})
export class PreloadPage implements OnInit, OnDestroy {
  intervalSubscription: Subscription | undefined;

  constructor(
    private storageService:  StorageService,
    private router: Router
  ) {}

  async ngOnInit() {
    this.intervalSubscription = interval(1500).subscribe(() => {
      this.storageService.get(ACCESS_TOKEN_EXPIRED_IN_KEY).then((expiredIn) => {
        const expiredAtTimeMillis = expiredIn * 1000;
        const currentTimeInMillis = Date.now();
        if (currentTimeInMillis >= expiredAtTimeMillis) {
          this.storageService.remove(ACCESS_TOKEN_KEY)
          this.storageService.remove(ACCESS_TOKEN_EXPIRED_IN_KEY)
        }
      })

      this.storageService.get(ACCESS_TOKEN_KEY).then((token) => {
        if (token) {
          this.router?.navigateByUrl('/home', { replaceUrl: true })
          return
        }
        this.router?.navigateByUrl('/signin', { replaceUrl: true })
      })
    })
  }

  async ngOnDestroy() {
    this.intervalSubscription?.unsubscribe()
  }
}
