import {Component, OnInit} from '@angular/core';
import {IonContent} from '@ionic/angular/standalone';
import {Router} from "@angular/router";
import {StorageService} from "../../../services/storage.service";
import {ACCESS_TOKEN_EXPIRED_IN_KEY, ACCESS_TOKEN_KEY, GRANT_ACCESS, VERIFY_ACCESS} from "../../utils/constants";
import {GrantAccessComponent} from "./components/grant-access.component";
import {HeaderComponent} from "./components/header.component";
import {CommonModule} from "@angular/common";
import {VerifyAccessComponent} from "./components/verify-access.component";

@Component({
  selector: 'app-signin',
  template: `
    <ion-content [fullscreen]="true">
      <div class="wrapper-sign ion-padding">
        <div class="box-section">
          <app-signin-header />
          <app-signin-grant-access
            *ngIf="currentSection === GRANT_ACCESS"
            (grantAccessEvent)="onCodeGenerated()"
          />
          <app-signin-verify-access
            *ngIf="currentSection === VERIFY_ACCESS"
            (verifyAccessEvent)="onCodeVerified($event)"
          />
        </div>
      </div>
    </ion-content>
  `,
  styles: [`
    ion-content {--overflow: hidden;}
    :host ion-input {--highlight-background: transparent;--border-style: solid;}
    .wrapper-sign {
      background: linear-gradient(180deg, rgba(197, 192, 192, 0.59) 21%, rgba(255, 255, 255, 0) 74%);
      border-radius: 0 !important;
      padding-bottom: 20px !important;
      padding-top: 40px !important;
      .box-section {
        margin-top: 48px;
        @media(min-width: 768px) {display: flex;flex-direction: column;align-items: center;}
      }
    }
  `],
  standalone: true,
  imports: [
    CommonModule,
    IonContent,
    HeaderComponent,
    GrantAccessComponent,
    VerifyAccessComponent
  ],
})
export class SigninPage implements OnInit {
  protected readonly GRANT_ACCESS = GRANT_ACCESS;
  protected readonly VERIFY_ACCESS = VERIFY_ACCESS;
  currentSection: string = GRANT_ACCESS;

  constructor(
    private storageService:  StorageService,
    private router: Router,
  ) { }

  async ngOnInit() {
    setTimeout(() => {
      this.storageService.get(ACCESS_TOKEN_KEY).then((token) => {
        if (token) {
          this.router?.navigateByUrl('/home', { replaceUrl: true })
          return
        }
      })
    }, 1)
  }

  onCodeGenerated() {
    this.currentSection = this.VERIFY_ACCESS
    console.log("code generated successfully")
  }

  async onCodeVerified(accessToken: string) {
    const expiredAtTimeMillis = Date.now() + (2628000 * 1000)
    const expiredAtInSeconds = Math.floor(expiredAtTimeMillis / 1000)
    await this.storageService.set(ACCESS_TOKEN_EXPIRED_IN_KEY, expiredAtInSeconds)
    await this.storageService.set(ACCESS_TOKEN_KEY, accessToken)
    await this.router.navigateByUrl('/home', { replaceUrl: true })
    console.log("code verified successfully")
  }
}
