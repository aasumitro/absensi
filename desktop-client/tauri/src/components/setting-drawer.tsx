"use client";

import { useState, useEffect, SetStateAction, Dispatch } from "react";
import {
  Drawer,
  DrawerContent,
  DrawerDescription,
  DrawerFooter,
  DrawerHeader,
  DrawerTitle,
  DrawerTrigger,
} from "./ui/drawer";
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "./ui/form";
import { Input } from "./ui/input";
import { Button } from "./ui/button";
import { Label } from "./ui/label";
import { ScrollArea } from "./ui/scroll-area";
import { RadioGroup, RadioGroupItem } from "./ui/radio-group";
import { QrCodeIcon, ScanLineIcon, Settings2 } from "lucide-react";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { z } from "zod";

interface SettingDrawerProps {
  callback: Dispatch<SetStateAction<boolean>>;
}

const formSchema = z.object({
  api_url: z.string().url(),
  device_id: z.string().uuid(),
  device_key: z.string(),
});

function SettingDrawer(props: SettingDrawerProps) {
  const [open, setOpen] = useState(false);
  const [mode, setMode] = useState<string>("generator");

  const form = useForm<z.infer<typeof formSchema>>({
    resolver: zodResolver(formSchema),
    defaultValues: {
      api_url: "",
      device_id: "",
      device_key: "",
    },
  });

  useEffect(() => {
    const storedData = localStorage.getItem("settings");
    if (storedData) {
      const settings = JSON.parse(storedData);
      form.reset({
        api_url: settings?.api_url,
        device_id: settings?.device_id,
        device_key: settings?.device_key,
      });
      setMode(settings?.device_mode);
    }
  }, []);

  const handleModeChange = (value: string) => setMode(value);

  function onSubmit(values: z.infer<typeof formSchema>) {
    const jsonData = JSON.stringify({
      api_url: values?.api_url,
      device_id: values?.device_id,
      device_key: values?.device_key,
      device_mode: mode,
    });
    localStorage.setItem("settings", jsonData);
    setOpen(false);
    props.callback(true);
  }

  return (
    <Drawer dismissible={false} open={open}>
      <DrawerTrigger asChild>
        <Button size="icon" variant="ghost" className="rounded-full" onClick={() => setOpen(true)}>
          <Settings2 className="h-4 w-4" />
        </Button>
      </DrawerTrigger>
      <DrawerContent>
        <DrawerHeader className="flex flex-col items-start text-left">
          <DrawerTitle>Pengaturan</DrawerTitle>
          <DrawerDescription>
            Sesuaikan konfigurasi untuk mengoptimalkan kinerja sistem.
          </DrawerDescription>
        </DrawerHeader>
        <Form {...form}>
          <form onSubmit={form.handleSubmit(onSubmit)}>
            <ScrollArea className="h-64">
              <div className="flex flex-col gap-2 px-4">
                <FormField
                  control={form.control}
                  name="api_url"
                  render={({ field }) => (
                    <FormItem>
                      <FormLabel>API URL</FormLabel>
                      <FormControl>
                        <Input placeholder=" http://localhost:8000" {...field} />
                      </FormControl>
                      <FormDescription>Backend/API URL</FormDescription>
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <div className="space-y-2">
                  <Label>Device Mode</Label>
                  <RadioGroup defaultValue={mode} className="grid grid-cols-3 gap-4">
                    <div className="text-center">
                      <RadioGroupItem
                        value="generator"
                        id="generator"
                        className="peer sr-only"
                      />
                      <Label
                        htmlFor="generator"
                        className="border-muted bg-popover hover:bg-accent hover:text-accent-foreground peer-data-[state=checked]:border-primary [&:has([data-state=checked])]:border-primary flex flex-col items-center justify-between rounded-md border-2 p-4"
                        onClick={() => handleModeChange("generator")}
                      >
                        <QrCodeIcon className="mb-3 h-6 w-6" />
                        QrCode Generator
                      </Label>
                    </div>
                    <div className="text-center">
                      <RadioGroupItem value="scanner" id="scanner" className="peer sr-only" />
                      <Label
                        htmlFor="scanner"
                        className="border-muted bg-popover hover:bg-accent hover:text-accent-foreground peer-data-[state=checked]:border-primary [&:has([data-state=checked])]:border-primary flex flex-col items-center justify-between rounded-md border-2 p-4"
                        onClick={() => handleModeChange("scanner")}
                      >
                        <ScanLineIcon className="mb-3 h-6 w-6" />
                        QrCode Scanner
                      </Label>
                    </div>
                  </RadioGroup>
                  <p className="text-muted-foreground text-[0.8rem]">
                    {mode === "generator"
                      ? "Mode GENERATOR akan menampilkan Kode QR yang bisa di pindai melalui Aplikasi Mobile."
                      : "Mode SCANNER akan membuka Kamera yang bisa memindai Kode QR yang di buat dari Aplikasi Mobile."}
                  </p>
                </div>
                <FormField
                  control={form.control}
                  name="device_id"
                  render={({ field }) => (
                    <FormItem>
                      <FormLabel>Device ID</FormLabel>
                      <FormControl>
                        <Input placeholder="00000000-0000-0000-0000-000000000000" {...field} />
                      </FormControl>
                      <FormDescription>Device unique identifier</FormDescription>
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormField
                  control={form.control}
                  name="device_key"
                  render={({ field }) => (
                    <FormItem>
                      <FormLabel>Device Key</FormLabel>
                      <FormControl>
                        <Input placeholder="* * * * * * * * * *" {...field} />
                      </FormControl>
                      <FormDescription>Device access key</FormDescription>
                      <FormMessage />
                    </FormItem>
                  )}
                />
              </div>
            </ScrollArea>
            <DrawerFooter className="flex w-screen flex-row-reverse justify-center">
              <Button className="w-full" type="submit">
                Simpan
              </Button>
              <Button type="button" onClick={() => setOpen(false)} className="w-full" variant="outline">
                 Batal
              </Button>
            </DrawerFooter>
          </form>
        </Form>
      </DrawerContent>
    </Drawer>
  );
}

export default SettingDrawer;
