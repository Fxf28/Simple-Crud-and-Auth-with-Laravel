import "./bootstrap";

import Alpine from "alpinejs";
import Swal from "sweetalert2";

// Pastikan SweetAlert2 tersedia secara global
window.Swal = Swal;

// Optional: Juga attach ke window untuk memastikan
window.SweetAlert = Swal;

window.Alpine = Alpine;

Alpine.start();
