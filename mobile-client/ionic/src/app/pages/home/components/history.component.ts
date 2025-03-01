import {Component, EventEmitter, Output} from "@angular/core";
import {IonText} from "@ionic/angular/standalone";
import {NgForOf, NgIf} from "@angular/common";

@Component({
  standalone: true,
  selector: 'app-history-component',
  template: `
    <div class="history">
      <div class="heading">
        <ion-text>Riwayat Absensi</ion-text>
        <button (click)="actionHistoryList.emit(true)">
          Lihat semua
        </button>
      </div>
      <div class="items" *ngFor="let index of [1, 2, 3, 4, 5]" (click)="actionHistoryDetail.emit(true)">
        <section class="presence" *ngIf="index !== 2">
          <div class="time">
            <ion-text class="title">Masuk</ion-text>
            <ion-text>08:00</ion-text>
          </div>
          <div class="time">
            <ion-text class="title">keluar</ion-text>
            <ion-text>14:00</ion-text>
          </div>
        </section>
        <section class="submission" *ngIf="index === 2">
          <div class="time">
            <ion-text class="title">Pengajuan</ion-text>
            <ion-text>25 - 29 Februari</ion-text>
            <ion-text class="subtitle">
              izin dalam rangka mengikuti kegiatan pelatihan
            </ion-text>
          </div>
        </section>
        <div> {{ "0"+index }} Februari 2021</div>
      </div>
    </div>
  `,
  styles: [`
    .history {
      gap: 14px;
      display: flex;
      flex-direction: column;
      .heading {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin-top: 18px;
        ion-text {
          font-weight: bold;
          font-size: 14px;
        }
        button {
          background: transparent;
          border-bottom: black 1px solid;
          font-size: 14px;
        }
      }
      .items {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 18px 28px;
        background: var(--ion-color-bg-grey);
        border-radius: 8px;
        &:hover {
          background: var(--ion-color-bg-grey-2);
        }
        .presence, .submission {
          display: flex;
          flex-direction: row;
          gap: 28px;
          width: 50%;
          .time {
            display: flex;
            flex-direction: column;
            ion-text {
              font-size: 14px;
              font-weight: bold;
              &.title {
                font-size: 10px;
                font-weight: normal;
                text-transform: uppercase;
              }
              &.subtitle {
                font-size: 8px;
                font-weight: lighter;
                text-transform: uppercase;
              }
            }
          }
        }
      }
    }
  `],
  imports: [
    IonText,
    NgForOf,
    NgIf
  ]
})
export class HistoryComponent {
  @Output() actionHistoryDetail = new EventEmitter<boolean>();
  @Output() actionHistoryList = new EventEmitter<boolean>();

  constructor() {}
}
