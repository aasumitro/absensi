import {Component, OnInit} from '@angular/core';
import {IonContent} from '@ionic/angular/standalone';
import {Router} from "@angular/router";
import {StorageService} from "../../../services/storage.service";
import {ACCESS_TOKEN_KEY,} from "../../utils/constants";
import {Weekday} from "../../models/weekday";
import {User} from "../../models/user";
import {HeaderComponent} from "./components/header.component";
import {DateSliderComponent} from "./components/date-slider.component";
import {PresenceComponent} from "./components/presence.component";
import {ProfileModalComponent} from "./components/profile-modal.component";
import {LeaveSubmissionModalComponent} from "./components/leave-modal.component";
import {HistoryComponent} from "./components/history.component";
import {HistoryDetailModalComponent} from "./components/history-detail-modal.component";
import {HistoryListModalComponent} from "./components/history-list-modal.component";

@Component({
  selector: 'app-home',
  template: `
    <ion-content class="ion-padding" [fullscreen]="true">
      <app-intro-component
        [user]="user"
        (callback)="displayProfileModal()"
      />

      <app-date-slider-component
        (callback)="selectedDayCallback($event)"
      />

      <app-presence-component
        [weekday]="day"
        (actionSubmission)="displayLeaveSubmissionModal()"
      />

      <app-history-component
        (actionHistoryDetail)="displayHistoryDetailModal()"
        (actionHistoryList)="displayHistoryListModal()"
      />

      <app-profile-modal-component
        [open]="profileModalState"
        (callback)="displayProfileModal()"
      />

      <app-leave-submission-modal-component
        [open]="leaveSubmissionModalState"
        (callback)="displayLeaveSubmissionModal()"
      />

      <app-history-detail-modal-component
        [open]="historyDetailModalState"
        (callback)="displayHistoryDetailModal()"
      />

      <app-history-list-modal-component
        [open]="historyListModalState"
        (callback)="displayHistoryListModal()"
      />
    </ion-content>
  `,
  standalone: true,
  imports: [
    IonContent,
    DateSliderComponent,
    HeaderComponent,
    PresenceComponent,
    ProfileModalComponent,
    LeaveSubmissionModalComponent,
    HistoryComponent,
    HistoryDetailModalComponent,
    HistoryListModalComponent,
  ],
})
export class HomePage implements OnInit {
  day: Weekday = {}
  user: User = {}

  profileModalState: boolean = false
  leaveSubmissionModalState: boolean = false
  historyDetailModalState: boolean = false
  historyListModalState: boolean = false

  constructor(
    private router: Router,
    private storageService:  StorageService,
  ) {}

  async ngOnInit() {
    this.user = {id: 1, username: `Ungke`} as User

    setTimeout(() => this.checkAccessToken(), 1)
  }

  async checkAccessToken() {
    const token = await this.storageService.get(ACCESS_TOKEN_KEY);
    if (!token) {
      this.router?.navigateByUrl('/signin', { replaceUrl: true });
    }
  }

  displayProfileModal = () => (this.profileModalState = !this.profileModalState)

  displayLeaveSubmissionModal = () => (this.leaveSubmissionModalState = !this.leaveSubmissionModalState)

  displayHistoryDetailModal = () => (this.historyDetailModalState = !this.historyDetailModalState)

  displayHistoryListModal = () => (this.historyListModalState = !this.historyListModalState)

  selectedDayCallback(day: Weekday) {
    if (day === this.day) return;

    this.day = day

    console.log('currentActiveDate', day)
  }
}
