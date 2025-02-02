import { Routes } from "@angular/router";
import {ContactComponent} from "./features/contact/contact.component";

export const CONTACTS_ROUTES: Routes = [
	{
		path: "add",
		component: ContactComponent,
	},
	{ path: "**", redirectTo: "add" },
];
