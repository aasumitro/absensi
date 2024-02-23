import {Component, EventEmitter, Input, Output} from "@angular/core";
import {IonFab, IonFabButton, IonIcon, IonText} from "@ionic/angular/standalone";
import {fingerPrint, stopwatch, chevronForward, logInOutline, logOutOutline, documentTextOutline} from "ionicons/icons";
import {Weekday} from "../../../models/weekday";
import {NgForOf} from "@angular/common";

@Component({
  standalone: true,
  selector: 'app-presence-component',
  template: `
    <div class="location">
      <section class="box distance">
        <ion-text class="title">Jarak dari kantor</ion-text>
        <ion-text class="value">250.287m</ion-text>
      </section>
      <section class="box map">
        <ion-text>Buka peta</ion-text>
      </section>
    </div>
    <div class="presence-card">
      <section class="block in"></section>
      <section class="rip"></section>
      <section class="block out"></section>

      <section class="presence">
        <div class="information">
          <ion-text class="date">
            {{ weekday.date }} {{ weekday.month }} {{weekday.year}}
          </ion-text>
          <div class="time">
            <ion-icon [icon]="stopwatch"></ion-icon>
            <ion-text>08:00 - 17:00</ion-text>
            <ion-icon [icon]="chevronForward"></ion-icon>
          </div>
        </div>
        <div class="attendance">
          <div class="item in">
            <ion-icon [icon]="logInOutline"></ion-icon>
            <div class="time">
              <ion-text class="title">MASUK</ion-text>
              <ion-text class="value">
                {{ weekday.date!! === today() ? "07:59:00" : "--:--:--" }}
              </ion-text>
            </div>
            <section class="crop"></section>
          </div>
          <div class="item out">
            <ion-icon [icon]="logOutOutline"></ion-icon>
            <div class="time">
              <ion-text class="title">KELUAR</ion-text>
              <ion-text class="value">
                {{ weekday.date!! === today() ? "15:59:00" : "--:--:--" }}
              </ion-text>
            </div>
            <section class="crop"></section>
          </div>
        </div>
      </section>

      <ion-fab>
        <ion-fab-button [disabled]="weekday.date!! < today()">
          <ion-icon [icon]="fingerPrint"></ion-icon>
        </ion-fab-button>
      </ion-fab>
    </div>
    <div class="leave-card" (click)="this.actionSubmission.emit(true)">
      <div class="mask"></div>
      <div class="cube" *ngFor="let index of [1, 2, 3, 4, 5, 6]"></div>
      <ion-icon [icon]="documentTextOutline"></ion-icon>
      <div class="info">
        <ion-text class="title">Pengajuan</ion-text>
        <ion-text class="subtitle">Buat pengajuan cuti, izin dan lainnya</ion-text>
      </div>
    </div>
  `,
  styles: [`
    .location {
      margin-top: 12px;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      gap: 18px;
      .box {
        width: 100%;
        border-radius: 8px;
        background: var(--ion-color-bg-grey);
        text-align: center;
        padding: 12px;
        &.distance {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          .title {
            font-size: 10px;
          }
          .value {
            font-size: 20px;
            font-weight: bold;
          }
        }
        &.map {
          display: flex;
          align-items: center;
          justify-content: center;
          background-image: url('../../../../assets/images/img.png');
          transition: background-color 0.3s ease;
          &:hover {
            opacity: 0.8;
          }
          ion-text {
            font-size: 16px;
            font-weight: bold;
          }
        }
      }
    }

    .presence-card {
      position: relative;
      display: flex;
      flex-direction: row;
      filter: drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.1));
      margin: 21px 0 0;
      height: 155px;
      .rip {
        position: relative;
        width: 80px;
        height: 100%;
        background-color: #fff;
        mask: radial-gradient(circle at center top, transparent 0, white 0) top,
        radial-gradient(circle at center bottom, transparent 34px, white 40px) bottom;
        mask-size: 100% 50%;
        mask-repeat: no-repeat;
      }
      .block {
        background-color: #fff;
        flex-grow: 1;
        flex-shrink: 1;
        &.in {
          border-top-left-radius: 8px;
        }
        &.out {
          border-top-right-radius: 8px;
        }
      }
      .presence {
        position: absolute;
        width: 100%;
        height: 100%;
        padding: 16px;
        .information {
          display: flex;
          flex-direction: row;
          align-items: center;
          justify-content: space-between;
          width: 100%;
          .date {
            font-weight: bold;
          }
          .time {
            display: flex;
            align-items: center;
            gap: 6px;
            ion-text {
              font-weight: normal;
            }
          }
        }
        .attendance {
          display: flex;
          flex-direction: row;
          margin-top: 12px;
          justify-content: space-between;
          align-items: center;
          gap: 20px;
          .item {
            text-align: center;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 18px;
            background: var(--ion-color-bg-grey);
            border-radius: 8px;
            ion-icon {
              font-size: 18px;
              color: white;
              background: var(--ion-color-medium);
              border-radius: 50%;
              padding: 6px;
            }
            &.in  {
              mask: radial-gradient(ellipse at bottom right, transparent 0, transparent 12%, white 12%) no-repeat;
            }
            &.out {
              flex-direction: row-reverse;
              mask: radial-gradient(ellipse at bottom left, transparent 0, transparent 12%, white 12%) no-repeat;
            }
            .time {
              display: flex;
              flex-direction: column;
              align-items: flex-start;
              .title {
                font-size: 10px;
                font-weight: bold;
              }
              .value {
                font-size: 14px;
                font-weight: lighter;
              }
            }
          }
        }
      }
      ion-fab {
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
      }
    }

    .leave-card {
      background-color: var(--ion-color-danger);
      &:hover {
        background-color: var(--ion-color-danger-tint);
      }
      padding: 24px 16px;
      display: flex;
      border-radius: 8px;
      margin-top: 4px;
      mask: radial-gradient(circle at center top, transparent 0, transparent 39px, white 40px) no-repeat;
      align-items: center;
      gap: 14px;
      position: relative;
      height: 100px;
      .mask {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 16px;
        background-color: white;
      }
      ion-icon {
        z-index: 1;
        margin-top: 16px;
        font-size: 21px;
        color: var(--ion-color-main-text);
        background: white;
        border-radius: 50%;
        padding: 8px;
      }
      .info {
        z-index: 1;
        margin-top: 16px;
        display: flex;
        flex-direction: column;
        ion-text {color: white;}
        .title {font-weight: bolder;}
        .subtitle {
          font-size: 12px;
        }
      }
      .cube {
        position: absolute;
        top: 80vh;
        left: -10px;
        width: 10px;
        height: 10px;
        border: solid 1px darken(#E7EDF3, 8%);
        transform-origin: top left;
        transform: scale(0) rotate(0deg) translate(-50%, -50%);
        animation: cube 12s ease-in forwards infinite;
        &:nth-child(2n) {
          border-color: lighten(#E7EDF3, 10%);
        }
        &:nth-child(2) {
          animation-delay: 2s;
          left: 25vw;
          top: 40vh;
        }
        &:nth-child(3) {
          animation-delay: 4s;
          left: 75vw;
          top: 50vh;
        }
        &:nth-child(4) {
          animation-delay: 6s;
          left: 90vw;
          top: 10vh;
        }
        &:nth-child(5) {
          animation-delay: 8s;
          left: 10vw;
          top: 85vh;
        }
        &:nth-child(6) {
          animation-delay: 10s;
          left: 50vw;
          top: 10vh;
        }
      }
      @keyframes cube {
        from {
          transform: scale(0) rotate(0deg) translate(-50%, -50%);
          opacity: 1;
        }
        to {
          transform: scale(20) rotate(960deg) translate(-50%, -50%);
          opacity: 0;
        }
      }
    }
  `],
  imports: [
    IonFab, IonFabButton, IonIcon, IonText, NgForOf
  ],
})
export class PresenceComponent {
  @Input() weekday: Weekday = {};
  @Output() actionSubmission = new EventEmitter<boolean>();

  constructor() {}

  protected readonly fingerPrint = fingerPrint;
  protected readonly stopwatch = stopwatch;
  protected readonly chevronForward = chevronForward;
  protected readonly logInOutline = logInOutline;
  protected readonly logOutOutline = logOutOutline;
  protected readonly documentTextOutline = documentTextOutline;

  today = (): number => parseInt((new Date()).getDate().toString().padStart(2, '0'))
}
