import { Component } from "@angular/core";
import { RouterLink } from "@angular/router";
import { ButtonModule } from "primeng/button";
import { CardModule } from "primeng/card";
import {ConnectionComponent} from "./connection/connection.component";
import {SplitterModule} from "primeng/splitter";

@Component({
  selector: "app-home",
  templateUrl: "./home.component.html",
  styleUrls: ["./home.component.scss"],
  standalone: true,
  imports: [CardModule, RouterLink, ButtonModule, ConnectionComponent, SplitterModule],
})
export class HomeComponent {
  public readonly appTitle = "ALTEN SHOP";
}
