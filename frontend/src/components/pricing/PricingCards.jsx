import React from "react";
import { PLANS } from "@/config/pricing";
import PricingCard from "./PricingCard";

export default function PricingCards({ compact = false }) {
  return (
    <div className="mx-auto grid max-w-[1360px] grid-cols-1 items-stretch gap-5 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
      {PLANS.map((plan) => (
        <PricingCard key={plan.id} plan={plan} compact={compact} />
      ))}
    </div>
  );
}
