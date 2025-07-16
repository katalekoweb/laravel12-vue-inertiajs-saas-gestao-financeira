<?php

function formatCurrency (mixed $value): string {
    return is_null($value) ? null : 'R$ ' . number_format($value, 2, ',', '.');
}