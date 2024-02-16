// Prevents additional console window on Windows in release, DO NOT REMOVE!!
#![cfg_attr(not(debug_assertions), windows_subsystem = "windows")]

use tauri::window::Window;
use tauri::command;

#[command]
fn exit(window: Window) {
    let _ = window.close();
}

#[command]
fn full_screen(window: Window, state: bool) {
    let _ = window.set_fullscreen(state);
}

fn main() {
    tauri::Builder::default()
        .invoke_handler(tauri::generate_handler![exit, full_screen])
        .run(tauri::generate_context!())
        .expect("error while running tauri application");
}

// call tauri app with param
// e.g:
// const setFullScreen = async (state: boolean) => invoke("full_screen", { state });
