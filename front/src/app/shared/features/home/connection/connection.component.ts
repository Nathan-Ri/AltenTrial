import {Component, inject} from '@angular/core';
import {Button} from "primeng/button";
import {FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators} from "@angular/forms";
import {AuthService} from "../../../services/auth.service";
import {ToastModule} from "primeng/toast";
import {MessageService} from "primeng/api";

@Component({
  selector: 'app-connection',
  standalone: true,
  imports: [
    Button,
    ReactiveFormsModule,
    FormsModule,
    ToastModule
  ],
  templateUrl: './connection.component.html',
  styleUrl: './connection.component.css'
})
export class ConnectionComponent {
  messageService: MessageService = inject(MessageService)
  loginForm: FormGroup;
  constructor(private formBuilder: FormBuilder) {
    this.loginForm = this.formBuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(3)]]
    });
  }
  authService = inject(AuthService)
  email?: string;
  password?: string;

  login() {
    this.authService.login(this.loginForm.value).subscribe({
      next: () => {
        this.messageService.add({ severity: 'success', summary: 'Success', detail: 'Connexion réussie' })
      },
      error: (error) => {
        this.messageService.add({ severity: 'error', summary: 'Error', detail: 'Connexion échouée' })
      }
    });
  }

}
