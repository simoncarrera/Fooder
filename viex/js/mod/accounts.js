var num_page = 1;
var data_accounts;
var rutaRelativa = location.href.split("/").pop();
let idReport_User;

var filter = rutaRelativa.includes("?filter=")
  ? rutaRelativa.split("?filter=")[1]
  : "all";
window.history.pushState(null, "", `?filter=${filter}`);

// Cambio el valor "seleccionado" del dropdown dependiendo del valor del filtro
if (filter == "all") {
  $("#item_actual").html("Todas");
  loadAccounts();
} else if (filter == "reporteds") {
  $("#item_actual").html("Reportadas");
  loadAccountsReported();
} else if (filter == "banneds") {
  $("#item_actual").html("Baneadas");
  loadAccountsBanned();
} else {
  if (filter == "admins") {
    $("#item_actual").html("Admins");
    rol_sekeer = 3;
  } else if (filter == "mods") {
    $("#item_actual").html("Mods");
    rol_sekeer = 2;
  } else {
    $("#item_actual").html("Usuarios Normales");
    rol_sekeer = 1;
  }
  loadAccountsRol(rol_sekeer);
}
var rol_sekeer;

//var num_page_reports = 1;
var data_reports_accounts;

$(".dropdown-item").click(function () {
  $("#container__specific").html("");
  item = $(this).html();
  num_page = 1;
  $("#item_actual").html(item);

  if (item == "Todas") {
    filter = "all";
    window.history.pushState(null, "", `?filter=${filter}`);
    loadAccounts();
  } else if (item == "Reportadas") {
    filter = "reporteds";
    window.history.pushState(null, "", `?filter=${filter}`);
    loadAccountsReported();
  } else if (item == "Baneadas") {
    filter = "banneds";
    window.history.pushState(null, "", `?filter=${filter}`);
    loadAccountsBanned();
  } else {
    if (item == "Admins") {
      filter = "admins";
      window.history.pushState(null, "", `?filter=${filter}`);
      rol_sekeer = 3;
    } else if (item == "Mods") {
      filter = "mods";
      window.history.pushState(null, "", `?filter=${filter}`);
      rol_sekeer = 2;
    } else {
      filter = "normal_users";
      window.history.pushState(null, "", `?filter=${filter}`);
      rol_sekeer = 1;
    }
    loadAccountsRol(rol_sekeer);
  }
});

$(window).on("scroll", function () {
  var scrollHeight = $(document).height();
  var scrollPosition = $(window).height() + $(window).scrollTop();
  if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
    if (data_accounts.amt_accounts_page >= num_page) {
      if (filter == "all") {
        loadAccounts();
      } else if (filter == "banneds") {
        loadAccountsBanned();
      } else if (filter == "reporteds") {
        loadAccountsReported();
      } else {
        loadAccountsRol(rol_sekeer);
      }
    }
  }
});

$(document).ready(function () {
  // INSERTAR MODAL CUANDO EL USUARIO HACE CLICK EN EL BOTON DE "VER REPORTES"
  $("#container__specific").on("click", ".account_reports", function () {
    var id = this.id.split("_").pop();
    if (typeof $(`#modalReportsAccounts_${id}`)[0] == "undefined") {
      loadReportsAccounts(id);
    }

    if (!document.getElementById(`modalReportsAccounts_${id}`).classList.contains("show")) {
      $(`#modalReportsAccounts_${id}`).modal("show");
    }
  });

  // ELIMINAR MODAL SI ES QUE EL USUARIO LO CIERRA
  $("#container__specific").on("click", ".btn-close-modal-reports", function () {
    if (this.dataset.closeType == "btn-x") {
      // Boton de x, cierro todo el modal
      $(this).modal("hide");
      var modal = this.parentNode.parentNode.parentNode.parentNode;
      num_page_reports = 1;
    } else {
      // Cancelar (cierro el modal-footer)
      var modal = this.parentNode.parentNode.parentNode;
    }
    $(modal).remove();
  }
  );

  // BOTON PARA MOSTRAR FORMULARIO PARA DESCARTAR REPORTE O BANEAR CUENTA
  $("#container__specific").on("click", ".report-discard-ban", function () {
    if (typeof $(`.modal-footer`)[0] != "undefined") {
      $(`.modal-footer`).remove();
    }

    let id = this.id.split("_").pop();
    let account_id = this.id.split("_")[1];
    let code_html = `
    <div class="modal-footer modal-footer-reports" id="modal-footer_${id}">
      <h6 class="m-0 mb-2">Sobre reporte: ${id}</h6>
      <form class="container__report--verdict form" id="form-verdict_${account_id}_${id}">
        <div class="container__inputs--reports">
          <div class="container__item--inputs">
            <span style="font-size:15px;">Veredicto ${(this.id.includes("ban"))? "(aclarar si es permaban)": ""}</span>
            <textarea id="textarea-verdict_${id}" class="form-control" placeholder="Ingrese un veredicto" name="verdict" required></textarea>
          </div>`;
    if (this.id.includes("ban")) {
      code_html += `
          <div class="container__item--inputs" style="width: auto;">
            <div>
              <span style="font-size:15px;">Tiempo de ban (hs)</span>
              <input type="number" class="form-control" name="time_banned" id="time_ended_${id}"> 
            </div>
            <div class="d-flex align-items-center mt-2">
              <span style="font-size:15px;" class="me-2">Permaban</span>
              <input type="checkbox" value="SI" name="time_banned" id="permaban_${id}"> 
            </div>
          </div>`;
    }
    code_html += `
        </div>
        <div class="container__options--submit">
          <button type="button" class="btn btn-secondary btn-close-modal-reports" data-close-type="btn-cancel">Cancelar</button>
          <button type="submit" id="banButton_${this.id.includes("ban") ? "1" : "0"}" class="btn btn-primary banButton_${this.id.includes("ban") ? "1" : "0"}">${this.id.includes("ban") ? "Banear cuenta" : "Descartar reporte"}</button>
        </div>
      </form>
    </div>`;
    $(
      this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode
    ).append(code_html);
  });

  // BOTON DE VER MAS EN LAS JUSTIFICACIONES DE LOS REPORTES
  $("#container__specific").on("click", ".btn-view-more-reports", function () {
    let id = this.id.split("_").pop();
    document
      .getElementById(`text-view-more-report_${id}`)
      .classList.toggle("d-none");

    if (this.innerText == "Ver más") {
      this.innerText = "Ver menos";
    } else {
      this.innerText = "Ver más";
    }
  });
});

// CARGAR TODAS LAS CUENTAS
function loadAccounts() {
  $.ajax({
    url: `../api/users/show.php`,
    type: "POST",
    data: { page: num_page, for: "accounts_all" },
    dataType: "JSON",
    beforeSend: function () {
      var icon_html = `
        <svg id="preload_accounts" class="w-100 " style="margin: 7px auto 0 auto;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve">
          <g>
            <linearGradient id="linear-gradient">
              <stop offset="0%" stop-color="#ffffff"/>
              <stop offset="100%" stop-color="#000000"/>
            </linearGradient>
            <path d="M63.85 0A63.85 63.85 0 1 1 0 63.85 63.85 63.85 0 0 1 63.85 0zm.65 19.5a44 44 0 1 1-44 44 44 44 0 0 1 44-44z" fill="url(#linear-gradient)" fill-rule="evenodd"/>
            <animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1080ms" repeatCount="indefinite"/>
          </g>
        </svg>`;
      $("#container__specific").append(icon_html);
    },
    success: function (data) {
      setTimeout(function () {
        $("#preload_accounts").remove();
        console.log(data);
        data_accounts = data;
        accounts = data_accounts.accounts;
        var option_html = ` `;
        $(".select2_opciones").remove();
        var code_html = "";
        accounts.forEach((account) => {
          //Momentaneo
          code_html += `
            <div class="container-v3" id="container-account_${account.id}">
                <div class="container-all" id="container-all-account_${account.id}">
                  <div class="container__img">
                      <a href="profile.php?id=${account.id}">
                        <img src="${account.profile_pic}" alt="foto perfil">
                      </a>
                  </div>
                  <div class="container__userdata">
                      <div class="container__userdata--username">
                        <a href="profile.php?id=${account.id}">${account.username}</a>
                      </div>
                      <div class="container__userdata--description">
                        <span>${account.biography != null ? account.biography : ""}</span>
                      </div>
                  </div>
                  <div class="container__options--mod d-flex">`;
          if (
            data_accounts.user_logged_role_id == 3 &&
            account.role_id != 3 &&
            data_accounts.user_logged_role_id != account.role_id
          ) {
            // Boton para mod/unmod
            code_html += `
                    <div id="container-mod_${account.id}" class="user_mod container__btn--${account.role_id == 2 ? "unmod" : "mod"}">
                      <a id="user_mod_${account.id}" class="btn btn-success" role="button">${account.role_id == 2 ? "Unmod" : "Mod"}</a>
                    </div>`;
          } else if (account.role_id == 2 || account.role_id == 3) {
            // "Cartel" que indica si el usuario es mod u admin
            code_html += `
                    <div class="container__btn--${account.role_id == 2 ? "unmod" : "admin"}">
                      <span class="btn">${account.role_id == 2 ? "Mod" : "Admin"}</span>
                    </div>`;
          }

          if (account.amt_reports > 0) {
            // Boton para ver reportes
            code_html += `
                    <div class="account_reports container__btn--view-reports ms-2 " id="container-account-reports_${account.id}">
                      <a id="account_reports_${account.id}" class="btn btn-light" role="button">Ver reportes</a>
                    </div>`;
          }

          code_html += `
                  </div>
                </div>
            </div>`;
          option_html += `<option class="select2_opciones" value="${account.id}">${account.username}</option>`;
        });

        $("#container__specific").append(code_html);
        $("#select2-accounts").append(option_html);
        num_page++;
      }, 250);
    },
  });
}

// CARGAR CUENTAS REPORTADAS
function loadAccountsReported() {
  // Cargar cuentas reportadas
  $.ajax({
    url: `../api/users/show.php`,
    type: "POST",
    data: { page: num_page, for: "accounts_reported_mod" },
    dataType: "JSON",
    beforeSend: function () {
      var icon_html = `<svg id="preload_accounts_reported" class="w-100 " style="margin: 7px auto 0 auto;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve"><g><linearGradient id="linear-gradient"><stop offset="0%" stop-color="#ffffff"/><stop offset="100%" stop-color="#000000"/></linearGradient><path d="M63.85 0A63.85 63.85 0 1 1 0 63.85 63.85 63.85 0 0 1 63.85 0zm.65 19.5a44 44 0 1 1-44 44 44 44 0 0 1 44-44z" fill="url(#linear-gradient)" fill-rule="evenodd"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1080ms" repeatCount="indefinite"/></g></svg>`;
      $("#container__specific").append(icon_html);
    },
    success: function (data) {
      setTimeout(function () {
        $("#preload_accounts_reported").remove();

        console.log(data);
        data_accounts = data;
        accounts_reported = data_accounts.accounts;
        var option_html = ` `;
        $(".select2_opciones").remove();
        var code_html = "";
        accounts_reported.forEach((account_reported) => {
          //Momentaneo
          code_html += `
            <div class="container-v3" id="container-account_${account_reported.id}">
                <div class="container-all" id="container-all-account_${account_reported.id}">
                  <div class="container__img">
                      <a href="profile.php?id=${account_reported.id}">
                        <img src="${account_reported.profile_pic}" alt="foto perfil">
                      </a>
                  </div>
                  <div class="container__userdata">
                      <div class="container__userdata--username">
                      <a href="profile.php?id=${account_reported.id}">${account_reported.username}</a>
                      </div>
                      <div class="container__userdata--description">
                      <span>${account_reported.biography != null ? account_reported.biography : ""}</span>
                      </div>
                  </div>
                  <div class="container__options--mod d-flex">`;
          if (data_accounts.user_logged_role_id == 3 && account_reported.role_id != 3 && data_accounts.user_logged_role_id != account_reported.role_id) {
            // Boton para mod/unmod
            code_html += `
                    <div id="container-mod_${account_reported.id}" class="user_mod container__btn--${account_reported.role_id == 2 ? "unmod" : "mod"}">
                      <a id="user_mod_${account_reported.id}" class="btn btn-success" role="button">${account_reported.role_id == 2 ? "Unmod" : "Mod"}</a>
                    </div>`;
          }

          // Boton para ver reportes
          code_html += `
                    <div class="account_reports container__btn--view-reports ms-2 " id="container-account-reports_${account_reported.id}">
                      <a id="account_reports_${account_reported.id}" class="btn btn-light" role="button">Ver reportes</a>
                    </div>
                  </div>
                </div>
            </div>`;

          option_html += `<option class="select2_opciones" value="${account_reported.id}">${account_reported.username}</option>`;
        });

        $("#container__specific").append(code_html);
        $("#select2-accounts").append(option_html);
        num_page++;
      }, 250);
    },
  });
}

// CARGAR CUENTAS BANEADAS
function loadAccountsBanned() {
  $.ajax({
    url: `../api/users/show.php`,
    type: "POST",
    data: { page: num_page, for: "accounts_banned_mod" },
    dataType: "JSON",
    beforeSend: function () {
      var icon_html = `<svg id="preload_accounts_ban" class="w-100 " style="margin: 7px auto 0 auto;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve"><g><linearGradient id="linear-gradient"><stop offset="0%" stop-color="#ffffff"/><stop offset="100%" stop-color="#000000"/></linearGradient><path d="M63.85 0A63.85 63.85 0 1 1 0 63.85 63.85 63.85 0 0 1 63.85 0zm.65 19.5a44 44 0 1 1-44 44 44 44 0 0 1 44-44z" fill="url(#linear-gradient)" fill-rule="evenodd"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1080ms" repeatCount="indefinite"/></g></svg>`;
      $("#container__specific").append(icon_html);
    },

    success: function (data) {
      setTimeout(function () {
        $("#preload_accounts_ban").remove();

        console.log(data);
        data_accounts = data;
        accounts_banned = data_accounts.accounts;
        var option_html = ` `;
        $(".select2_opciones").remove();
        var code_html = "";
        accounts_banned.forEach((account_banned) => {
          //Momentaneo
          code_html += `
            <div class="container-v3" id="container-account_${account_banned.id}">
                <div class="container-all" id="container-all-account_${account_banned.id}">
                  <div class="container__img">
                      <a href="profile.php?id=${account_banned.id}">
                      <img src="${account_banned.profile_pic}" alt="foto perfil">
                      </a>
                  </div>
                  <div class="container__userdata">
                      <div class="container__userdata--username">
                      <a href="profile.php?id=${account_banned.id}">${account_banned.username}</a>
                      </div>
                      <div class="container__userdata--description">
                      <span>${account_banned.biography != null ? account_banned.biography : ""}</span>
                      </div>
                  </div>
                  <div class="container__options--mod d-flex align-items-center">
                    <div class="me-2">`;
          if (account_banned.ban_end) {
            code_html += `
                      <span class="">Cuenta baneada desde ${new Date(account_banned.ban_start).toLocaleDateString()} hasta ${new Date(account_banned.ban_end).toLocaleDateString()}</span>`
          } else {
            code_html += `
                    <span class="">Cuenta baneada durante tiempo indefinido</span>`
          }
          code_html += `
                    </div>`;
          if (data_accounts.user_logged_role_id == 3 && account_banned.role_id != 3 && data_accounts.user_logged_role_id != account_banned.role_id) {
            // Boton para ban/unban
            code_html += `
                    <div id="container-unban_${account_banned.id}" class="user_unban container__btn--unban">
                      <a id="user_unban_${account_banned.id}" class="btn btn-outline-danger" role="button">Unban</a>
                    </div>`;
          }
          code_html += `
                    <div class="container__btn--view-bans ms-2 ">
                    </div>
                  </div>
                </div>
            </div>`;
          option_html += `<option class="select2_opciones" value="${account_banned.id}">${account_banned.username}</option>`;
        });

        $("#container__specific").append(code_html);
        $("#select2-accounts").append(option_html);
        num_page++;
      }, 250);
    },
  });
}

// CARGAR CUENTAS POR ROL
function loadAccountsRol(rol_sekeer) {
  // Cargar cuentas
  $.ajax({
    url: `../api/users/show.php`,
    type: "POST",
    data: { page: num_page, for: "accounts_rol_mod", rol_sekeer: rol_sekeer },
    dataType: "JSON",
    beforeSend: function () {
      var icon_html = `<svg id="preload_accounts_rol" class="w-100 " style="margin: 7px auto 0 auto;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve"><g><linearGradient id="linear-gradient"><stop offset="0%" stop-color="#ffffff"/><stop offset="100%" stop-color="#000000"/></linearGradient><path d="M63.85 0A63.85 63.85 0 1 1 0 63.85 63.85 63.85 0 0 1 63.85 0zm.65 19.5a44 44 0 1 1-44 44 44 44 0 0 1 44-44z" fill="url(#linear-gradient)" fill-rule="evenodd"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1080ms" repeatCount="indefinite"/></g></svg>`;
      $("#container__specific").append(icon_html);
    },
    success: function (data) {
      setTimeout(function () {
        $("#preload_accounts_rol").remove();
        console.log(data);
        data_accounts = data;
        accounts = data_accounts.accounts;
        var code_html = "";
        $(".select2_opciones").remove();
        var option_html = ``;
        $("#select2-accounts").append(option_html);
        accounts.forEach((account) => {
          //Momentaneo
          code_html += `
            <div class="container-v3" id="container-account_${account.id}">
                <div class="container-all" id="container-all-account_${account.id}">
                  <div class="container__img">
                      <a href="profile.php?id=${account.id}">
                        <img src="${account.profile_pic}" alt="foto perfil">
                      </a>
                  </div>
                  <div class="container__userdata">
                      <div class="container__userdata--username">
                        <a href="profile.php?id=${account.id}">${account.username}</a>
                      </div>
                      <div class="container__userdata--description">
                        <span>${account.biography != null ? account.biography : ""}</span>
                      </div>
                  </div>
                  <div class="container__options--mod d-flex">`;
          if (data_accounts.user_logged_role_id == 3 && account.role_id != 3 && data_accounts.user_logged_role_id != account.role_id) {
            // Boton para mod/unmod
            code_html += `
                    <div id="container-mod_${account.id}" class="user_mod container__btn--${account.role_id == 2 ? "unmod" : "mod"}">
                      <a id="user_mod_${account.id}" class="btn btn-success" role="button">${account.role_id == 2 ? "Unmod" : "Mod"}</a>
                    </div>`;
          } else if (account.role_id == 2 || account.role_id == 3) {
            // "Cartel" que indica si el usuario es mod u admin
            code_html += `
                    <div class="container__btn--${account.role_id == 2 ? "unmod" : "admin"}">
                      <span class="btn">${account.role_id == 2 ? "Mod" : "Admin"}</span>
                    </div>`;
          }

          if (account.amt_reports > 0) {
            // Boton para ver reportes
            code_html += `
                    <div class="account_reports container__btn--view-reports ms-2 " id="container-account-reports_${account.id}">
                      <a id="account_reports_${account.id}" class="btn btn-light" role="button">Ver reportes</a>
                    </div>`;
          }

          code_html += `
                  </div>
                </div>
            </div>`;

          option_html += `<option class="select2_opciones" value="${account.id}">${account.username}</option>`;
        });
        $("#select2-accounts").append(option_html);
        $("#container__specific").append(code_html);

        num_page++;
      }, 250);
    },
  });
}

// CARGO MODAL DE REPORTES DE X CUENTA
function loadReportsAccounts(account_id) {
  $.ajax({
    url: `../api/reports/show.php`,
    type: "POST",
    async: false,
    data: {
      page: num_page_reports,
      for: "reports_accounts_mod",
      account_id: account_id,
    },
    dataType: "JSON",
    success: function (data) {
      console.log(data);
      data_reports_accounts = data;
      reports_accounts = data_reports_accounts.reports;

      var code_html = `
        <div class="modal fade" id="modalReportsAccounts_${account_id}" data-bs-backdrop="static" data-modal-type="modal-view-reports" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog " style="max-width: 800px;">
            <div class="modal-content" id="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Reportes de la cuenta: ${data_reports_accounts.username_reported}</h5>
                <button type="button" class="btn-close btn-close-modal-reports" data-bs-dismiss="modal" data-close-type="btn-x" aria-label="Close"><i class="bi bi-x-lg"></i></button>
              </div>
              <div class="modal-body">`;

      reports_accounts.forEach((report_account) => {
        code_html += `
                <div class="container__report" id="container-report_${report_account.id}">
                        <div class="container__data--report">
                            <div class="report__username--date">
                                <div class="report__username">
                                    ${report_account.username_reporter} (${report_account.reporter_user_id})
                                </div>
                                
                                <div class="report__date">
                                  • ${report_account.created_at}
                                </div>
                            </div>
                            <div class="report__about">
                                Reporte: ${report_account.id}
                            </div>
                            <div class="report__reason--justification">
                                <div class="report__reason">
                                    <span class="report__reason--title">Razon</span>
                                    <span class="report__reason--content">${report_account.reason}</span>
                                </div>
                                <div class="report__justification">
                                    <span class="report__justification--title">Justificacion</span>
                                    <span class="report__justification--content">${report_account.justification.slice(0, 220)}`;
        if (report_account.justification.slice(220, 1000)) {
          code_html += `...<span id="text-view-more-report_${report_account.id}" class="d-none">${report_account.justification.slice(220, 1000)}</span> <button type="button" class="btn btn-view-more-reports p-0" id="view-more-report_${report_account.id}">Ver más</button>`;
        }

        code_html += `             </span>
                                </div>
                            </div>
                        </div>
                        <!-- Descartar/Eliminar -->
                        <div class="container__options--report">
                            <div class="dropdown ps-2 ms-auto">
                      		<button title="Opciones de moderacion" class="btn p-0 dropbtn" id="btn_delete-edit-${report_account.id}"><i class="bi bi-three-dots"></i></button>
                      		<div id="dropdown_delete-edit-${report_account.id}" class="dropdown-content" style="right: -10px; top: 32px;">
                        		<a class="dropdown-content__edit report-discard-ban" id="btn-discard-report_${report_account.reported_user_id}_${report_account.id}" role="button"><i class="bi bi-recycle"></i> Descartar reporte</a>
                        		<a class="dropdown-content__delete report-discard-ban" id="btn-ban-account_${report_account.reported_user_id}_${report_account.id}" role="button" ><i class="bi bi-x-octagon"></i> Banear cuenta</a>
                      		</div>
                    	    </div>
                        </div>
                    </div>`;
      });

      code_html += `
                </div>
            </div>
          </div>
        </div>`;

      $(`#container-all-account_${account_id}`).append(code_html);
      num_page_reports++;
    },
  });
}

// FUNCIONALIDAD DE DESCARTAR REPORTE O BANEAR CUENTA
$("#container__specific").on("submit", ".container__report--verdict", function (e) {
    e.preventDefault();
    let report_id = this.id.split("_").pop();
    let verdict = $(`#textarea-verdict_${report_id}`).val();
    let modal = this.parentNode.parentNode.parentNode.parentNode;
    let modal_footer = this.parentNode;
    let report_html = $(`#container-report_${report_id}`)[0];

  if (document.getElementById(`time_ended_${report_id}`) == null && document.getElementById(`permaban_${report_id}`) == null) {
      // Descartar reporte
      $.ajax({
        url: "../api/reports/discard.php",
        type: "POST",
        data: { verdict: verdict, id: report_id },
        dataType: "JSON",
        success: function (data) {
          console.log(data);

          report_html.remove();
          if (
            document.getElementsByClassName("container__report").length == 0
          ) {
            $(modal).modal("hide");
            if (data.message == "Hecho") {
              let timerInterval;
              Swal.fire({
                html: "Reporte descartado con exito",
                timer: 1200,
                timerProgressBar: false,
                position: "bottom-start",
                showConfirmButton: false,
                width: "auto",
                padding: "2px",
                grow: "row",
                backdrop: true,
                toast: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                stopKeydownPropagation: false,
                background: "#fdb801",
                color: "#ffffff",
                willClose: () => {
                  clearInterval(timerInterval);
                },
              });
            } else {
              let timerInterval;
              Swal.fire({
                html: "Error al descartar reporte",
                timer: 1200,
                timerProgressBar: false,
                position: "bottom-start",
                showConfirmButton: false,
                width: "auto",
                padding: "2px",
                grow: "row",
                backdrop: true,
                toast: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                stopKeydownPropagation: false,
                background: "#fdb801",
                color: "#ffffff",
                willClose: () => {
                  clearInterval(timerInterval);
                },
              });
            }
            if (filter == "reporteds") {
              $(
                `#container-account_${data_reports_accounts.user_reported_id}`
              ).remove();
            } else {
              $(
                `#container-account-reports_${data_reports_accounts.user_reported_id}`
              ).remove();
            }
          }
          modal_footer.remove();
          num_page_reports = 1;
        },
      });
    } else {
      // Banear cuenta
      if (document.getElementById(`time_ended_${report_id}`).value != "") {
        var ban_ended = parseInt($(`#time_ended_${report_id}`).val()) * 60 * 60;
      } else {
        var permaban = $(`#permaban_${report_id}`).val()
      }
      $.ajax({
        url: `../api/users/ban.php`,
        type: "POST",
        data: {
          for: "Banned_acount",
          user_banned_id: data_reports_accounts.user_reported_id,
          report_id: report_id,
          ban_ended: (typeof ban_ended != 'undefined') ? ban_ended : null,
          permaban: (typeof permaban != 'undefined') ? permaban : null,
          verdict: verdict
        },
        dataType: "JSON",
        success: function (data) {
          console.log(data);

          $(modal).modal("hide");
          modal.remove();
          if (data.message == "Hecho") {
            let timerInterval;
            Swal.fire({
              html: "Usuario baneado con exito",
              timer: 1200,
              timerProgressBar: false,
              position: "bottom-start",
              showConfirmButton: false,
              width: "auto",
              padding: "2px",
              grow: "row",
              backdrop: true,
              toast: true,
              allowOutsideClick: false,
              allowEscapeKey: false,
              stopKeydownPropagation: false,
              background: "#fdb801",
              color: "#ffffff",
              willClose: () => {
                clearInterval(timerInterval);
              },
            });
          } else {
            let timerInterval;
            Swal.fire({
              html: "Error al banear al usuario",
              timer: 1200,
              timerProgressBar: false,
              position: "bottom-start",
              showConfirmButton: false,
              width: "auto",
              padding: "2px",
              grow: "row",
              backdrop: true,
              toast: true,
              allowOutsideClick: false,
              allowEscapeKey: false,
              stopKeydownPropagation: false,
              background: "#fdb801",
              color: "#ffffff",
              willClose: () => {
                clearInterval(timerInterval);
              },
            });
          }
          $(
            `#container-account_${data_reports_accounts.user_reported_id}`
          ).remove();
          num_page_reports = 1;
        },
      });
    }
  }
);

$("#container__specific").on("click", ".user_unban", function () {
  let user_id = this.id.split("_")[1];

  $.ajax({
    url: "../api/users/ban.php",
    type: "POST",
    data: { user_banned_id: user_id },
    dataType: "JSON",
    success: function (data) {
      console.log(data);
      if (data.action == "Unban") {
        $(`#container-account_${user_id}`).remove();
      }
    },
  });
});


$("#select2-accounts").select2({minimumInputLength: 3, placeholder: "Search", allowClear: true });

$("#select2_form").submit(function (e) {
  e.preventDefault();
  $(".container-v3").show();

  if ($("#select2-accounts").val() == "") {
    $(".container-v3").show();
  } else {
    $(".container-v3")
      .not("#container-account_" + $("#select2-accounts").val())
      .hide();
  }
});
