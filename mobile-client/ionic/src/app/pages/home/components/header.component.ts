import {Component, EventEmitter, Input, Output} from "@angular/core";
import {IonAvatar, IonImg, IonText} from "@ionic/angular/standalone";
import {User} from "../../../models/user";
import {Weekday} from "../../../models/weekday";

@Component({
  standalone: true,
  selector: 'app-intro-component',
  template: `
    <section class="container ion-padding">
      <div class="intro">
        <ion-text class="title">꩜ Absensi</ion-text>
        <ion-text class="subtitle">Hai {{ user.username }}, {{ getGreeting() }}.</ion-text>
      </div>
      <ion-avatar class="avatar">
        <ion-img
          src="https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/avatars/00/004605892bb95a676f6b26f2f7617b117bf7e0fb.jpg"
          alt="absensi-logo"
          (click)="callback.emit()"
        ></ion-img>
      </ion-avatar>
    </section>
  `,
  styles: [`
    .container {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      .intro {
        display: flex;
        flex-direction: column;
        .title {font-size: 24px; font-weight: bolder;}
        .subtitle {font-size: 14px; font-weight: normal;}
      }
      .avatar {
        background-color: #f1f1f1;
        transition: background-color 0.3s;
        &:active {background-color: #c5c5c5;}
        ion-img {padding: 12px;}
      }
    }
  `],
  imports: [
    IonAvatar,
    IonImg,
    IonText
  ]
})
export class HeaderComponent {
  @Input() user: User = {};
  @Output() callback = new EventEmitter<Weekday>();

  getGreeting = (): string => {
    const currentTime = new Date();
    const currentHour = currentTime.getHours();
    if (currentHour < 11)  return "Selamat Pagi";
    if (currentHour < 14)  return "Selamat Siang";
    if (currentHour < 18)  return "Selamat Sore";
    return "Selamat Malam";
  }
}
