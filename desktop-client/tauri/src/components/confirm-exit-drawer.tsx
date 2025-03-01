import {
  Drawer,
  DrawerClose,
  DrawerContent,
  DrawerDescription,
  DrawerFooter,
  DrawerHeader,
  DrawerTitle,
  DrawerTrigger,
} from "./ui/drawer";
import { Button } from "./ui/button";
import { XIcon } from "lucide-react";
import { invoke } from "@tauri-apps/api/tauri";

function ConfirmExitDrawer() {
  const exitApp = async () => invoke("exit");

  return (
    <Drawer>
      <DrawerTrigger asChild>
        <Button size="icon" variant="ghost" className="rounded-full">
          <XIcon className="h-4 w-4" />
        </Button>
      </DrawerTrigger>
      <DrawerContent>
        <DrawerHeader className="flex flex-col items-start text-left">
          <DrawerTitle>Anda yakin?</DrawerTitle>
          <DrawerDescription>Tindakan ini akan menutup aplikasi.</DrawerDescription>
        </DrawerHeader>
        <DrawerFooter className="flex w-screen flex-row-reverse justify-center">
          <Button className="w-full" variant="destructive" onClick={exitApp}>
            Ya, tutup!
          </Button>
          <DrawerClose className="w-full border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50">
              Batal
          </DrawerClose>
        </DrawerFooter>
      </DrawerContent>
    </Drawer>
  );
}

export default ConfirmExitDrawer;
