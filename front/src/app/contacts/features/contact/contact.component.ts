import {Component, inject, OnInit} from '@angular/core';
import {FormControl, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {InputTextareaModule} from "primeng/inputtextarea";
import {ToastModule} from "primeng/toast";
import {MessageService} from "primeng/api";
import {ChipsModule} from "primeng/chips";

@Component({
  selector: 'app-add-contact',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    InputTextareaModule,
    ToastModule,
    ChipsModule
  ],
  templateUrl: './contact.component.html',
})
export class ContactComponent {
  messageService = inject(MessageService)
  protected formGroup: FormGroup;

  constructor() {
    this.formGroup = new FormGroup({
      email: new FormControl<String | null>(null, [Validators.required, Validators.email]),
      message: new FormControl<String | null>(null, [Validators.required]),
    });
    this.formGroup.reset()
  }

  onSubmit() {
    this.messageService.add({ severity: 'success', summary: 'Success', detail: 'Demande de contact envoyé avec succès' })
    this.formGroup.reset()
  }
}
