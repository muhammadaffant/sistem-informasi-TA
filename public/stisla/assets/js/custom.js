/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(".custom-file-input").on("change", function () {
  let filename = $(this).val().split("\\").pop();
  $(this).next(".custom-file-label").addClass("selected").html(filename);
});

$('[data-toggle="tooltip"]').tooltip();

$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});

function preview(target, image) {
  $(target).attr("src", window.URL.createObjectURL(image)).show();
}

function resetForm(selector) {
  $(selector)[0].reset();

  // Reset Summernote editor content
  $(selector)
    .find(".summernote")
    .each(function () {
      $(this).summernote("code", "");
    });

  // Reset image thumbnail and custom file label
  $(selector).find(".img-thumbnail").attr("src", "").hide();
  $(selector).find(".custom-file-label").text("Choose file");

  // Reset Select2 elements
  $(selector).find(".select2").val(null).trigger("change");

  // Reset custom file inputs
  $(".custom-file-input").next(".custom-file-label").text("Choose file");
  $(".custom-file-input").val("");

  // Trigger change for Select2 and form controls
  $(".select2").val("").trigger("change");
  $(".select2").trigger("change");

  // Remove invalid styles
  $(
    ".form-control, .custom-select, [type=radio], [type=checkbox], [type=file], .select2, .note-editor"
  ).removeClass("is-invalid");
  $(".invalid-feedback").remove();
}

function loopForm(originalForm) {
  for (const field in originalForm) {
    const $fieldElement = $(`[name=${field}]`);
    const fieldType = $fieldElement.attr("type");

    if (fieldType !== "file") {
      if ($fieldElement.hasClass("summernote")) {
        $fieldElement.summernote("code", originalForm[field]);
      } else if (fieldType === "checkbox") {
        $fieldElement
          .filter(`[value="${originalForm[field]}"]`)
          .prop("checked", true);
      } else if (fieldType === "radio") {
        $fieldElement
          .filter(`[value="${originalForm[field]}"]`)
          .prop("checked", true);
      } else {
        $fieldElement.val(originalForm[field]);
      }

      if ($fieldElement.is("select")) {
        $fieldElement.trigger("change");
      }
    } else {
      $(`.preview-${field}`).attr("src", originalForm[field]).show();
    }
  }
}

function loopErrors(errors) {
  // Hapus semua umpan balik kesalahan sebelumnya
  $(".invalid-feedback").remove();
  $(".is-invalid").removeClass("is-invalid");

  if (!errors) {
    return;
  }

  for (let error in errors) {
    const field = $(`[name="${error}"]`);
    const errorMessage = `<div class="invalid-feedback">${errors[error][0]}</div>`;

    // Tambahkan class is-invalid untuk validasi bootstrap
    field.addClass("is-invalid");

    if (field.hasClass("select2")) {
      // Untuk elemen select2
      $(errorMessage).insertAfter(field.next(".select2-container"));
    } else if (field.hasClass("summernote")) {
      // Untuk elemen summernote
      $(".note-editor").addClass("is-invalid");
      $(errorMessage).insertAfter(field.next());
    } else if (field.hasClass("custom-control-input")) {
      // Untuk elemen custom checkbox/radio
      $(errorMessage).insertAfter(field.closest(".custom-control"));
    } else {
      // Untuk input lainnya
      if (field.length === 0) {
        // Jika elemen adalah array (name="field[]")
        $(`[name="${error}[]"]`).addClass("is-invalid");
        $(errorMessage).insertAfter($(`[name="${error}[]"]`).next());
      } else {
        if (
          field.next().hasClass("input-group-append") ||
          field.next().hasClass("input-group-prepend")
        ) {
          // Untuk input-group
          $(errorMessage).insertAfter(field.parent());
        } else {
          $(errorMessage).insertAfter(field);
        }
      }
    }
  }
}

function formatRupiah(value) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(value);
}

function format_uang(input) {
  let value = input.value || input.toString();
  value = value.replace(/[^\d]/g, "");
  let formatted = "";
  const length = value.length;

  for (let i = length; i > 0; i--) {
    if ((length - i) % 3 === 0 && i !== length) {
      formatted = value.charAt(i - 1) + "." + formatted;
    } else {
      formatted = value.charAt(i - 1) + formatted;
    }
  }

  if (input.value === undefined) {
    return formatted;
  }

  input.value = formatted;
}

var path = location.pathname.split("/");
var url = location.origin + "/" + path[1] + "/" + path[2];

$("ul.sidebar-menu li a").each(function () {
  if ($(this).attr("href").indexOf(url) !== -1) {
    $(this)
      .parent()
      .addClass("active")
      .parent()
      .parent("li")
      .addClass("active");
  }
});
